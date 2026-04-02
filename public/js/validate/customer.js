
document.getElementById('customerForm').addEventListener('submit', function(e) {

    let isValid = true;

    // reset lỗi
    document.querySelectorAll('.error').forEach(el => el.innerText = '');

    const customer_code = document.getElementById('customer_code').value.trim();
    const name = document.getElementById('name').value.trim();
    const phone = document.getElementById('phone').value.trim();
    const address = document.getElementById('address').value.trim();
    const email = document.getElementById('email').value.trim();
    // ===== REQUIRED =====

    if (!customer_code) {
        document.getElementById('error-customer_code').innerText = 'Mã khách hàng không được để trống';
        isValid = false;
    } else if (customer_code.length > 50) {
        document.getElementById('error-customer_code').innerText = 'Tối đa 50 ký tự';
        isValid = false;
    }

    if (!name) {
        document.getElementById('error-name').innerText = 'Tên không được để trống';
        isValid = false;
    } else if (name.length > 255) {
        document.getElementById('error-name').innerText = 'Tối đa 255 ký tự';
        isValid = false;
    }

    // ===== OPTIONAL =====
    if(!phone){
        document.getElementById('error-phone').innerText = 'SĐT không được để trống';
        isValid = false;
    }
    if (phone && phone.length > 20) {
        document.getElementById('error-phone').innerText = 'SĐT tối đa 20 ký tự';
        isValid = false;
    }

    if (address && address.length > 255) {
        document.getElementById('error-address').innerText = 'Địa chỉ tối đa 255 ký tự';
        isValid = false;
    }

    if (email) {
        const regex = /^\S+@\S+\.\S+$/;
        if (!regex.test(email)) {
            document.getElementById('error-email').innerText = 'Email không hợp lệ';
            isValid = false;
        } else if (email.length > 255) {
            document.getElementById('error-email').innerText = 'Email tối đa 255 ký tự';
            isValid = false;
        }
    }

    // ===== NUMBER (nullable nhưng nếu có thì phải hợp lệ) =====

    function validateNumber(value, field, label) {
        if (value !== '') {
            if (isNaN(value) || Number(value) < 0) {
                document.getElementById('error-' + field).innerText = label + ' phải là số >= 0';
                return false;
            }
        }
        return true;
    }

    // ===== STOP SUBMIT =====
    if (!isValid) {
        e.preventDefault();
    }
});
