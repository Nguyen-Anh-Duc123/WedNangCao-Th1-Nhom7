# Giới thiệu dự án

## Tổng quan
Đây là website thương mại điện tử dành cho phụ kiện/thiết bị chơi game (tay cầm, console, phụ kiện). Giao diện hiện đại, màu nhấn cam, có phiên bản tiếng Việt/English và hỗ trợ đổi tiền tệ VND/USD.

## Công nghệ sử dụng (theo project hiện tại)
- Backend: PHP ^8.1, Laravel ^9
- Database: MySQL / MariaDB
- Frontend: Blade, HTML, CSS, JavaScript
- Thư viện giỏ hàng: bumbummen99/shoppingcart
- UI/Icons: Bootstrap 4, Font Awesome
- Build tool: Laravel Mix (webpack)
- Thư viện JS kèm theo: jQuery, axios, Vue 2 (devDependencies)
- Biểu đồ admin: Morris.js

## Chức năng chính (Frontend)
- Trang chủ có banner và sản phẩm nổi bật.
- Cửa hàng (Shop): danh sách sản phẩm theo lưới, phân loại theo danh mục & thương hiệu, tìm kiếm.
- Chi tiết sản phẩm: hình ảnh, mô tả, giá, thêm vào giỏ, yêu thích.
- Giỏ hàng:
  - Hiển thị sản phẩm, giá, số lượng.
  - Tăng/giảm số lượng bằng nút +/– (tự cập nhật), không cần nút cập nhật.
  - Tổng tiền và chuyển sang checkout.
- Checkout:
  - Form giao hàng một bên, tóm tắt đơn + phương thức thanh toán một bên.
  - Bố cục 2 cột gọn, căn giữa.
- Thanh toán giả lập:
  - Chọn phương thức và xác nhận hoàn tất đơn ngay tại trang.
- Yêu thích (Wishlist): thêm/xóa sản phẩm.
- Tin tức: danh sách + chi tiết bài viết (full width, không sidebar).
- Đa ngôn ngữ VI/EN và đổi tiền tệ.
- Hiệu ứng “bay vào giỏ” khi thêm sản phẩm.

## Chức năng quản trị (Admin)
- Đăng nhập admin và dashboard tổng quan.
- Dashboard thống kê:
  - Doanh thu tháng (chỉ tính đơn **Đã giao** + **Đã thanh toán**).
  - Tổng người dùng, tổng đơn hàng tháng, tổng thương hiệu.
  - Biểu đồ doanh thu & đơn hàng 6 tháng gần nhất.
- Quản lý đơn hàng:
  - Xem chi tiết đơn.
  - Cập nhật trạng thái giao hàng.
  - Cập nhật trạng thái thanh toán.
  - Đơn đã thanh toán sẽ **khóa chỉnh sửa**.

## Luồng đơn hàng
1. Người dùng thêm sản phẩm vào giỏ.
2. Checkout nhập thông tin giao hàng.
3. Thanh toán giả lập: chọn phương thức và xác nhận.
4. Đơn được đánh dấu **Đã giao** + **Đã thanh toán** ngay sau xác nhận.
5. Doanh thu dashboard chỉ tính các đơn đã giao & đã thanh toán.

## Giao diện & bố cục
- Banner chỉ xuất hiện ở trang chủ.
- Các trang khác chỉ hiển thị nội dung (không banner).
- Trang contact/tin tức/chi tiết sản phẩm ẩn sidebar danh mục.
- Trang shop có sidebar được thiết kế nền trắng, chữ đen, hiển thị số lượng sản phẩm theo danh mục.

## Cấu hình database
1. Tạo database (ví dụ: `webapp`)
2. Cập nhật file `.env`:
   - `DB_CONNECTION=mysql`
   - `DB_HOST=127.0.0.1`
   - `DB_PORT=3306`
   - `DB_DATABASE=webapp`
   - `DB_USERNAME=your_user`
   - `DB_PASSWORD=your_password`
3. Import dữ liệu mẫu:
   - File: `database/elaravel.sql`

## File chính
- Giao diện: `resources/views/**`
- CSS chính: `public/frontend/css/modern.css`
- JS hiệu ứng: `public/frontend/js/cart-fly.js`, `public/frontend/js/cart-qty.js`
- Controllers: `app/Http/Controllers/**`
- Routes: `routes/web.php`

## Ghi chú
- Đây là demo thanh toán giả lập (không tích hợp cổng thanh toán thật).
- Một số dữ liệu mẫu có thể được seed từ database mẫu trong `database/elaravel.sql`.
