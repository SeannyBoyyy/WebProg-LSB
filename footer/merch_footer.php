    <!-- Footer -->
    <footer class="text-white py-4" style="background: #301934;">
        <div class="container text-center">
            <p>&copy; 2024 Lyceum of Subic Bay. All Rights Reserved.</p>
            <div>
                <a href="#" class="text-white me-3">Facebook</a>
                <a href="#" class="text-white me-3">Twitter</a>
                <a href="#" class="text-white me-3">Instagram</a>
                <a href="./admin/index.php?active=dashboard" class="text-white">Admin</a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- GLightbox JS -->
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/glightbox.min.js"></script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script>
        // Initialize Swiper
        var swiper = new Swiper('.init-swiper', JSON.parse(document.querySelector('.swiper-config').innerHTML));
        
        document.addEventListener("scroll", function() {
            const header = document.getElementById("navbar");
            if (window.scrollY > 50) {
                header.classList.add("scrolled");
            } else {
                header.classList.remove("scrolled");
            }
        });

    </script>