    </main>
    <footer class="ad-footer">
        <div class="footer-content">
            <p>&copy; <?php echo date('Y'); ?> PetCare. Đồng hành cùng thú cưng.</p>
            <p>Liên hệ: <a href="mailto:support@petcare.com">support@petcare.com</a> | Điện thoại: 000-123-456</p>
            <p>Địa chỉ: 18 Phạm Hùng, Từ Liêm, Hà Nội</p>
            <p>Thời gian hiện tại: <?php echo date('H:i A, d/m/Y'); ?></p>
        </div>
    </footer>
</body>
</html>

<style> 
    .ad-footer {
    position: relative;
    margin-top: 200px; /* tạo khoảng cách với nội dung */
    bottom: 0;
    left: 0;
    width: 100%;
    background: linear-gradient(135deg, var(--main-blue), #0077a3);
    color: var(--white);
    text-align: center;
    padding: 40px 20px;
    z-index: 2000;
    box-shadow: 0 -4px 10px rgba(0, 0, 0, 0.2);
}
</style>