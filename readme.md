# 🎮 Hệ thống Website Bán Tay Cầm Chơi Game

[cite_start]**Đồ án học phần:** Thiết kế Web Nâng cao [cite: 1]
[cite_start]**Giảng viên hướng dẫn:** Nguyễn Thị Thùy Liên [cite: 1]
[cite_start]**Đơn vị:** Trường Công nghệ thông tin - Đại học Phenikaa [cite: 1]
[cite_start]**Nhóm thực hiện:** Nhóm 7 [cite: 1]

---

## 👥 Thành viên nhóm & Phân công nhiệm vụ
| STT | Họ và Tên | MSSV | Vai trò chính |
|-----|-----------|------|---------------|
| 1 | **Nguyễn Anh Đức** | 23010650 | [cite_start]Dashboard, CRUD Sản phẩm/Tin tức, Xử lý hiển thị dữ liệu [cite: 1, 6] |
| 2 | **Bùi Văn Khoa** | 23012842 | [cite_start]Giao diện (UI/UX), Responsive, Header/Search, Trang chi tiết [cite: 1, 2] |
| 3 | **Đỗ Tùng Lâm** | 23010874 | [cite_start]Xử lý đặt hàng (Checkout), Admin Order, Validate form [cite: 1, 4] |

---

## 🚀 Giới thiệu dự án
[cite_start]Đây là website thương mại điện tử chuyên kinh doanh các phụ kiện và thiết bị chơi game (Console, Tay cầm...)[cite: 27]. [cite_start]Hệ thống được xây dựng theo mô hình **MVC** (Model - View - Controller) [cite: 30][cite_start], hỗ trợ đa ngôn ngữ (Việt/Anh) và chuyển đổi tiền tệ[cite: 28].

---

## 🛠 Công nghệ sử dụng
* [cite_start]**Backend:** PHP 8.1, Laravel Framework 9[cite: 33].
* [cite_start]**Database:** MySQL / MariaDB[cite: 35].
* [cite_start]**Frontend:** Blade Template, Bootstrap 4, Font Awesome[cite: 38, 41].
* [cite_start]**Libraries:** jQuery, Axios, Morris.js (Biểu đồ)[cite: 42, 44].

---

## ⚙️ Chức năng chính
### [cite_start]1. Phía Người dùng (Client) [cite: 49]
* **Tài khoản:** Đăng ký, Đăng nhập, Quản lý thông tin cá nhân.
* [cite_start]**Sản phẩm:** Xem danh sách, Chi tiết sản phẩm, Lọc theo giá/thương hiệu[cite: 57, 69].
* [cite_start]**Mua hàng:** Thêm vào giỏ hàng, Cập nhật số lượng, Thanh toán (Checkout)[cite: 62, 63].
* [cite_start]**Tiện ích:** Tìm kiếm sản phẩm thông minh[cite: 68].

### [cite_start]2. Phía Quản trị (Admin) [cite: 73]
* [cite_start]**Dashboard:** Thống kê doanh thu, số lượng đơn hàng qua biểu đồ[cite: 76].
* [cite_start]**Quản lý:** Sản phẩm, Danh mục, Người dùng[cite: 77, 78, 79].
* [cite_start]**Đơn hàng:** Xem chi tiết đơn hàng, Cập nhật trạng thái giao hàng/thanh toán[cite: 80].

---

## 🔧 Hướng dẫn cài đặt (Localhost)
1.  **Clone dự án:**
    ```bash
    git clone [https://github.com/Nguyen-Anh-Duc123/WedNangCao-Th1-Nhom7.git](https://github.com/Nguyen-Anh-Duc123/WedNangCao-Th1-Nhom7.git)
    cd WedNangCao-Th1-Nhom7
    ```

2.  **Cài đặt thư viện:**
    ```bash
    composer install
    ```

3.  **Cấu hình môi trường:**
    * Copy file `.env.example` thành `.env`.
    * Cấu hình thông tin DB trong file `.env`: `DB_DATABASE=elaravel` 

4.  **Khởi chạy:**
    ```bash
    php artisan key:generate
    php artisan migrate
    php artisan serve
    ```
    Truy cập: `http://127.0.0.1:8000`

---
© 2026 - Nhóm 7 Phenikaa University