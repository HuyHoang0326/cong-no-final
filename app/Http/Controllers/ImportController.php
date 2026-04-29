<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Car;
use App\Models\CarBrand;
use App\Models\Parst;
use App\Models\ParstsCategory;
use App\Models\Supplier;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ImportController extends Controller
{
    /* =======================
     * ======== CAR ==========
     * ======================= */

    // ================= UPLOAD =================
    public function uploadCar(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv'
        ], [
            'file.mimes' => 'File không đúng định dạng. Chỉ chấp nhận Excel (.xlsx) hoặc CSV (.csv)'
        ]);

        $file = $request->file('file');

        // check extension thật
        $ext = strtolower($file->getClientOriginalExtension());
        if (!in_array($ext, ['xlsx', 'csv'])) {
            return back()->withErrors([
                'file' => 'Chỉ hỗ trợ file .xlsx hoặc .csv'
            ]);
        }

        // đọc file an toàn
        try {
            $data = Excel::toArray([], $file);
        } catch (\Exception $e) {
            return back()->withErrors([
                'file' => 'File Excel không hợp lệ hoặc bị lỗi định dạng'
            ]);
        }

        // check dữ liệu rỗng
        if (empty($data) || empty($data[0]) || empty($data[0][0])) {
            return back()->withErrors([
                'file' => 'File không có dữ liệu hợp lệ'
            ]);
        }

        $headers = $data[0][0];

        session(['excel_car' => $data]);

        $suppliers = Supplier::all();
        $warehouses = Warehouse::all();
        $brands = CarBrand::all();

        return view('import.car.mapping', compact(
            'headers',
            'suppliers',
            'warehouses',
            'brands'
        ));
    }

    public function viewMappingCar()
    {
        $data = session('excel_car');
        $headers = $data[0][0] ?? [];

        $suppliers = Supplier::all();
        $warehouses = Warehouse::all();
        $brands = CarBrand::all();

        return view('import.car.mapping', compact(
            'headers',
            'suppliers',
            'warehouses',
            'brands'
        ));
    }

    // ================= RUN =================
    public function runCar(Request $request)
    {
        $dateFields = ['buy_date', 'stock_in_date', 'sale_date'];

        $mapping = $request->mapping ?? [];
        $mode = $request->mode ?? [];
        $manual = $request->manual ?? [];

        $data = session('excel_car');

        if (!$data) return "Mất session";

        $rows = $data[0];
        $result = [];

        foreach ($rows as $key => $row) {

            if ($key == 0) continue;

            $isEmpty = empty(array_filter($row, fn($v) => $v !== null && $v !== ''));
            if ($isEmpty) continue;

            $insert = [];

            foreach ($mapping as $field => $excelIndex) {

                $currentMode = $mode[$field] ?? 'skip';

                // ===== EXCEL =====
                if ($currentMode === 'excel') {

                    if ($excelIndex !== '' && $excelIndex !== null) {

                        $value = $row[$excelIndex] ?? null;
                        if ($field === 'payload') {
                            $value = $this->normalizePayload($value);
                        }
                        // date
                        if (in_array($field, $dateFields)) {
                            $value = $this->excelDateToDB($value);
                        }

                        if ($field === 'document_in_stock') {
                            $insert['document_in_stock'] = $this->handleDocumentInStockToArray($value);
                            continue;
                        }

                        $insert[$field] = $value;
                    }
                }

                // ===== MANUAL =====
                elseif ($currentMode === 'manual') {

                    $value = $manual[$field] ?? null;

                    if (in_array($field, $dateFields)) {
                        $value = $this->excelDateToDB($value);
                    }

                    $insert[$field] = $value;
                }
            }

            if (!empty(array_filter($insert, fn($v) => $v !== null && $v !== ''))) {
                $result[] = $insert;
            }
        }

        session(['import_cars' => $result]);

        return redirect()->route('import.preview.car');
    }

    // ================= PREVIEW =================
    public function previewCar()
    {
        $suppliers = Supplier::all();
        $warehouses = Warehouse::all();
        $brands = CarBrand::all();

        return view('import.car.preview', compact(
            'suppliers',
            'warehouses',
            'brands'
        ));
    }

    // ================= STORE =================
    public function storeCar(Request $request)
    {
        $cars = $request->items;

        DB::transaction(function () use ($cars) {
            foreach ($cars as $car) {
                Car::create($car);
            }
        });

        return redirect()->route('cars.index');
    }


    /* =======================
     * ======= PARST =========
     * ======================= */

    public function uploadParst(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv'
        ], [
            'file.mimes' => 'File không đúng định dạng. Chỉ chấp nhận Excel (.xlsx) hoặc CSV (.csv)'
        ]);

        $file = $request->file('file');

        // check extension thật
        $ext = strtolower($file->getClientOriginalExtension());
        if (!in_array($ext, ['xlsx', 'csv'])) {
            return back()->withErrors([
                'file' => 'Chỉ hỗ trợ file .xlsx hoặc .csv'
            ]);
        }

        // đọc file an toàn
        try {
            $data = Excel::toArray([], $file);
        } catch (\Exception $e) {
            return back()->withErrors([
                'file' => 'File Excel không hợp lệ hoặc bị lỗi định dạng'
            ]);
        }

        // check dữ liệu
        if (empty($data) || empty($data[0]) || empty($data[0][0])) {
            return back()->withErrors([
                'file' => 'File không có dữ liệu hợp lệ'
            ]);
        }

        $headers = $data[0][0];

        session([
            'excel_data' => $data
        ]);

        $suppliers = Supplier::all();
        $categories = ParstsCategory::all();
        $warehouses = Warehouse::all();

        return view('import.parst.mapping', compact(
            'headers',
            'suppliers',
            'categories',
            'warehouses'
        ));
    }

    public function viewMappingParst()
    {
        $data = session('excel_data');
        $headers = $data[0][0] ?? [];

        //  load lại DB (quan trọng)
        $suppliers = Supplier::all();
        $categories = ParstsCategory::all();
        $warehouses = Warehouse::all();

        return view('import.parst.mapping', compact(
            'headers',
            'suppliers',
            'categories',
            'warehouses'
        ));
    }

    public function runParst(Request $request)
    {
        $dateFields = ['buy_date', 'stock_in_date', 'sale_date'];
        $mapping = $request->mapping ?? [];
        $mode = $request->mode ?? [];
        $manual = $request->manual ?? [];

        $data = session('excel_data');

        if (!$data) return "Mất session";

        $rows = $data[0];
        $result = [];

        foreach ($rows as $key => $row) {
            if ($key == 0) continue;
            $isExcelRowEmpty = empty(array_filter($row, fn($v) => $v !== null && $v !== ''));
            if ($isExcelRowEmpty) continue;
            $insert = [];

            foreach ($mapping as $field => $excelIndex) {

                $currentMode = $mode[$field] ?? 'skip';

                //  lấy từ excel
                if ($currentMode === 'excel') {

                    if ($excelIndex !== '' && $excelIndex !== null) {

                        $value = $row[$excelIndex] ?? null;
                        if ($field === 'item_condition') {
                            $value = $this->normalizeItemCondition($value);
                        }
                        if (in_array($field, $dateFields)) {
                            $value = $this->excelDateToDB($value);
                        }

                        $insert[$field] = $value;
                    }
                }

                //  nhập tay
                elseif ($currentMode === 'manual') {
                    $value = $manual[$field] ?? null;

                    if (in_array($field, $dateFields)) {
                        $value = $this->excelDateToDB($value);
                    }

                    $insert[$field] = $value;
                }

                // skip → bỏ qua
            }

            //  bỏ dòng rỗng
            if (!empty(array_filter($insert, fn($v) => $v !== null && $v !== ''))) {
                $result[] = $insert;
            }
        }

        // lưu session
        session([
            'import_parsts' => $result
        ]);

        return redirect()->route('import.preview.parst');
    }

    public function previewParst()
    {
        $suppliers = Supplier::all();
        $categories = ParstsCategory::all();
        $warehouses = Warehouse::all();

        return view('import.parst.preview', compact(
            'suppliers',
            'categories',
            'warehouses'
        ));
    }

    public function storeParst(Request $request)
    {
        $parsts = $request->items;

        DB::transaction(function () use ($parsts) {
            foreach ($parsts as $parst) {
                Parst::create($parst);
            }
        });

        return redirect()->route('parsts.index');
    }

    function excelDateToDB($value)
    {
        if (!$value) return null;

        try {
            // Excel dạng số (46075)
            if (is_numeric($value)) {
                return \Carbon\Carbon::createFromTimestamp(($value - 25569) * 86400)
                    ->format('Y-m-d');
            }

            // dd/mm/yyyy
            if (preg_match('/\d{2}\/\d{2}\/\d{4}/', $value)) {
                return \Carbon\Carbon::createFromFormat('d/m/Y', $value)
                    ->format('Y-m-d');
            }

            // các dạng còn lại
            return \Carbon\Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    function normalizeItemCondition($value)
    {
        if (!$value) return null;

        // chuẩn hoá text
        $value = mb_strtolower(trim($value), 'UTF-8');

        // bỏ dấu tiếng Việt (quan trọng)
        $value = Str::ascii($value);

        // nhóm NEW
        $newValues = [
            'new',
            'moi',
            'not used',
            'chua su dung',
            '0'
        ];

        // nhóm USED
        $usedValues = [
            'cu',
            'old',
            'da su dung',
            'used',
            'bai',
            'hang bai',
            '1'
        ];

        if (in_array($value, $newValues)) return 0;
        if (in_array($value, $usedValues)) return 1;

        return null; // không match
    }

    private function removeVietnamese($str)
    {
        $str = strtolower($str);

        $map = [
            'á' => 'a',
            'à' => 'a',
            'ả' => 'a',
            'ã' => 'a',
            'ạ' => 'a',
            'ă' => 'a',
            'ắ' => 'a',
            'ằ' => 'a',
            'ẳ' => 'a',
            'ẵ' => 'a',
            'ặ' => 'a',
            'â' => 'a',
            'ấ' => 'a',
            'ầ' => 'a',
            'ẩ' => 'a',
            'ẫ' => 'a',
            'ậ' => 'a',

            'é' => 'e',
            'è' => 'e',
            'ẻ' => 'e',
            'ẽ' => 'e',
            'ẹ' => 'e',
            'ê' => 'e',
            'ế' => 'e',
            'ề' => 'e',
            'ể' => 'e',
            'ễ' => 'e',
            'ệ' => 'e',

            'í' => 'i',
            'ì' => 'i',
            'ỉ' => 'i',
            'ĩ' => 'i',
            'ị' => 'i',

            'ó' => 'o',
            'ò' => 'o',
            'ỏ' => 'o',
            'õ' => 'o',
            'ọ' => 'o',
            'ô' => 'o',
            'ố' => 'o',
            'ồ' => 'o',
            'ổ' => 'o',
            'ỗ' => 'o',
            'ộ' => 'o',
            'ơ' => 'o',
            'ớ' => 'o',
            'ờ' => 'o',
            'ở' => 'o',
            'ỡ' => 'o',
            'ợ' => 'o',

            'ú' => 'u',
            'ù' => 'u',
            'ủ' => 'u',
            'ũ' => 'u',
            'ụ' => 'u',
            'ư' => 'u',
            'ứ' => 'u',
            'ừ' => 'u',
            'ử' => 'u',
            'ữ' => 'u',
            'ự' => 'u',

            'ý' => 'y',
            'ỳ' => 'y',
            'ỷ' => 'y',
            'ỹ' => 'y',
            'ỵ' => 'y',

            'đ' => 'd'
        ];

        return strtr($str, $map);
    }
    private function normalizePayload($value)
    {
        if (!$value) return null;

        // chuẩn hóa
        $value = strtolower(trim($value));

        // bỏ khoảng trắng
        $value = preg_replace('/\s+/u', '', $value);

        // đổi dấu phẩy
        $value = str_replace(',', '.', $value);

        // bỏ dấu tiếng Việt
        $value = $this->removeVietnamese($value);

        //  bảng mapping cứng
        $map = [
            // ===== 1 tấn =====
            '1t' => 1,
            '1tan' => 1,
            '1' => 1,
            '1000kg' => 1,
            '1000' => 1,
            '10ta' => 1,

            // ===== 1.5 =====
            '1.5t' => 1.5,
            '1.5tan' => 1.5,
            '1500kg' => 1.5,
            '1500kg' => 1.5,
            '15ta' => 1.5,

            // ===== 2 =====
            '2t' => 2,
            '2tan' => 2,
            '2000kg' => 2,
            '2000' => 2,
            '20ta' => 2,

            // ===== 2.5 =====
            '2.5t' => 2.5,
            '2.5tan' => 2.5,
            '2500kg' => 2.5,
            '2500' => 2.5,
            '25ta' => 2.5,

            // ===== 3 =====
            '3t' => 3,
            '3tan' => 3,
            '3000kg' => 3,
            '3000' => 3,
            '30ta' => 3,

            // ===== 3.5 =====
            '3.5t' => 3.5,
            '3.5tan' => 3.5,
            '3500kg' => 3.5,
            '3500' => 3.5,
            '35ta' => 3.5,

            // ===== 5 =====
            '5t' => 5,
            '5tan' => 5,
            '5000kg' => 5,
            '5000' => 5,
            '50ta' => 5,

            // ===== 6 =====
            '6t' => 6,
            '6tan' => 6,
            '6000kg' => 6,
            '6000' => 6,

            // ===== 7 =====
            '7t' => 7,
            '7tan' => 7,
            '7000kg' => 7,
            '7000' => 7,

            // ===== 10 =====
            '10t' => 10,
            '10tan' => 10,
            '10000kg' => 10,
            '10000' => 10,
        ];

        //  match trực tiếp
        if (isset($map[$value])) {
            return $map[$value];
        }

        //  fallback: lấy số nếu có
        preg_match('/\d+(\.\d+)?/', $value, $matches);

        if ($matches) {
            $number = floatval($matches[0]);

            // chỉ cho phép list chuẩn
            $allowed = [1, 1.5, 2, 2.5, 3, 3.5, 5, 6, 7, 10];

            if (in_array($number, $allowed)) {
                return $number;
            }
        }

        return null; //  không hợp lệ thì reject luôn
    }

    private function handleDocumentInStockToArray($value)
    {
        if (!$value) return [];

        // ===== normalize =====
        $text = trim($value);
        $text = Str::lower($value);
        $text = Str::ascii($text);
        $text = preg_replace('/[^a-z0-9]/', '', $text);

        // ===== keyword map =====
        $map = [
            'hop_dong' => ['hd', 'hopdong', 'contract'],
            'dang_kiem' => ['dk', 'dangkiem', 'inspection'],
            'hai_quan' => ['hq', 'haiquan', 'customs'],
        ];

        $negative = ['khong', 'ko', 'chua', 'thieu'];

        $result = [];

        foreach ($map as $key => $keywords) {

            foreach ($keywords as $k) {

                if (str_contains($text, $k)) {

                    // check phủ định
                    $isNegative = false;

                    foreach ($negative as $neg) {
                        if (str_contains($text, $neg . $k)) {
                            $isNegative = true;
                            break;
                        }
                    }

                    if (!$isNegative) {
                        $result[] = $key;
                    }

                    break;
                }
            }
        }

        // ===== case đủ giấy =====
        if (
            str_contains($text, 'dugiayto') ||
            str_contains($text, 'giaodugiayto') ||
            str_contains($text, 'dagiaodugiayto') ||
            str_contains($text, 'giaodu') ||
            str_contains($text, 'daydu') ||
            str_contains($text, 'full') ||
            str_contains($text, 'complete')
        ) {
            return ['hop_dong', 'dang_kiem', 'hai_quan'];
        }

        return $result;
    }
}
