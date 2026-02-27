/**
 * TOGA Racing Theme JavaScript
 *
 * @package TOGA_Racing
 */

(function () {
    'use strict';

    /**
     * Mobile Navigation Toggle
     */
    function initMobileNav() {
        const toggle = document.querySelector('.menu-toggle');
        const menu = document.querySelector('.primary-menu');

        if (!toggle || !menu) return;

        toggle.addEventListener('click', function () {
            const expanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', !expanded);
            menu.classList.toggle('active');

            // Animate hamburger
            this.classList.toggle('active');
        });

        // Close menu when clicking a link
        menu.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () {
                menu.classList.remove('active');
                toggle.setAttribute('aria-expanded', 'false');
                toggle.classList.remove('active');
            });
        });

        // Close menu when clicking outside
        document.addEventListener('click', function (e) {
            if (!toggle.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.remove('active');
                toggle.setAttribute('aria-expanded', 'false');
                toggle.classList.remove('active');
            }
        });
    }

    /**
     * Header scroll effect
     */
    function initHeaderScroll() {
        const header = document.querySelector('.site-header');
        if (!header) return;

        let lastScroll = 0;

        window.addEventListener('scroll', function () {
            const currentScroll = window.pageYOffset;

            if (currentScroll > 100) {
                header.style.boxShadow = '0 2px 20px rgba(0, 255, 10, 0.1)';
            } else {
                header.style.boxShadow = 'none';
            }

            lastScroll = currentScroll;
        }, { passive: true });
    }

    /**
     * Gallery Lightbox
     */
    function initLightbox() {
        const lightbox = document.getElementById('gallery-lightbox');
        if (!lightbox) return;

        const lightboxImage = lightbox.querySelector('.lightbox-image');
        const lightboxCaption = lightbox.querySelector('.lightbox-caption');
        const closeBtn = lightbox.querySelector('.lightbox-close');
        const prevBtn = lightbox.querySelector('.lightbox-prev');
        const nextBtn = lightbox.querySelector('.lightbox-next');
        const overlay = lightbox.querySelector('.lightbox-overlay');

        let currentIndex = 0;
        let galleryImages = [];

        // Collect all gallery triggers
        function collectImages() {
            galleryImages = [];
            document.querySelectorAll('.gallery-lightbox-trigger, .gallery-item a, .wp-block-image a').forEach(function (el) {
                const href = el.getAttribute('href');
                if (href && (href.match(/\.(jpg|jpeg|png|gif|webp)/i) || el.classList.contains('gallery-lightbox-trigger'))) {
                    galleryImages.push({
                        src: href,
                        caption: el.getAttribute('data-caption') || ''
                    });
                }
            });
        }

        // Open lightbox
        function openLightbox(index) {
            if (galleryImages.length === 0) return;

            currentIndex = index;
            updateLightboxImage();
            lightbox.classList.add('active');
            lightbox.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }

        // Close lightbox
        function closeLightbox() {
            lightbox.classList.remove('active');
            lightbox.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }

        // Update displayed image
        function updateLightboxImage() {
            if (galleryImages[currentIndex]) {
                lightboxImage.src = galleryImages[currentIndex].src;
                lightboxCaption.textContent = galleryImages[currentIndex].caption;
            }
        }

        // Navigate
        function nextImage() {
            currentIndex = (currentIndex + 1) % galleryImages.length;
            updateLightboxImage();
        }

        function prevImage() {
            currentIndex = (currentIndex - 1 + galleryImages.length) % galleryImages.length;
            updateLightboxImage();
        }

        // Event listeners
        document.addEventListener('click', function (e) {
            const trigger = e.target.closest('.gallery-lightbox-trigger, .gallery-item a, .wp-block-image a');
            if (trigger) {
                const href = trigger.getAttribute('href');
                if (href && href.match(/\.(jpg|jpeg|png|gif|webp)/i)) {
                    e.preventDefault();
                    collectImages();

                    // Find index
                    const index = galleryImages.findIndex(function (img) {
                        return img.src === href;
                    });

                    openLightbox(index >= 0 ? index : 0);
                }
            }
        });

        if (closeBtn) closeBtn.addEventListener('click', closeLightbox);
        if (overlay) overlay.addEventListener('click', closeLightbox);
        if (nextBtn) nextBtn.addEventListener('click', nextImage);
        if (prevBtn) prevBtn.addEventListener('click', prevImage);

        // Keyboard navigation
        document.addEventListener('keydown', function (e) {
            if (!lightbox.classList.contains('active')) return;

            switch (e.key) {
                case 'Escape':
                    closeLightbox();
                    break;
                case 'ArrowRight':
                    nextImage();
                    break;
                case 'ArrowLeft':
                    prevImage();
                    break;
            }
        });
    }

    /**
     * Gallery Filters
     */
    function initGalleryFilters() {
        const filters = document.querySelectorAll('.gallery-filter');
        const items = document.querySelectorAll('.gallery-item');

        if (filters.length === 0) return;

        filters.forEach(function (filter) {
            filter.addEventListener('click', function () {
                const category = this.getAttribute('data-filter');

                // Update active state
                filters.forEach(function (f) { f.classList.remove('active'); });
                this.classList.add('active');

                // Filter items
                items.forEach(function (item) {
                    const itemCat = item.getAttribute('data-category');
                    if (category === 'all' || itemCat === category || itemCat === 'all') {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    }

    /**
     * Smooth scroll for anchor links
     */
    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
            anchor.addEventListener('click', function (e) {
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    const headerHeight = document.querySelector('.site-header').offsetHeight || 80;
                    const targetPos = target.getBoundingClientRect().top + window.pageYOffset - headerHeight;

                    window.scrollTo({
                        top: targetPos,
                        behavior: 'smooth'
                    });
                }
            });
        });
    }

    /**
     * Initialize everything on DOM ready
     */
    document.addEventListener('DOMContentLoaded', function () {
        initMobileNav();
        initHeaderScroll();
        initLightbox();
        initGalleryFilters();
        initSmoothScroll();
    });

})();
