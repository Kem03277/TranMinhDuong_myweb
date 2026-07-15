// File mặc định của Laravel (Axios, CSRF, cấu hình...)
import './bootstrap';
// Import thư viện Bootstrap từ node_modules
import 'bootstrap';

window.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.add-to-cart-btn').forEach((button) => {
        button.addEventListener('click', function () {
            const productId = this.getAttribute('data-product-id');
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            window.axios.post('/cart/add', { product_id: productId }, {
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }).then((response) => {
                const alertBox = document.createElement('div');
                alertBox.className = 'alert alert-success position-fixed top-0 end-0 m-3 shadow';
                alertBox.innerText = response.data.message || 'Đã thêm vào giỏ hàng';
                document.body.appendChild(alertBox);
                setTimeout(() => alertBox.remove(), 1800);

                const countEl = document.getElementById('cart-count');
                if (countEl) {
                    countEl.innerText = response.data.count || 0;
                }
            }).catch(() => {
                const alertBox = document.createElement('div');
                alertBox.className = 'alert alert-danger position-fixed top-0 end-0 m-3 shadow';
                alertBox.innerText = 'Không thể thêm vào giỏ hàng';
                document.body.appendChild(alertBox);
                setTimeout(() => alertBox.remove(), 1800);
            });
        });
    });
});