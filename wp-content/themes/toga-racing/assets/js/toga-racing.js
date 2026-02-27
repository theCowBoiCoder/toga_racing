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

        // Get full-size image URL from an element
        function getImageSrc(el) {
            // Check if it's a link to an image file
            var href = el.tagName === 'A' ? el.getAttribute('href') : null;
            if (href && href.match(/\.(jpg|jpeg|png|gif|webp)/i)) {
                return href;
            }
            // Fall back to the img src (for images without links or linking to attachment pages)
            var img = el.tagName === 'IMG' ? el : el.querySelector('img');
            if (img) {
                // Use full-size src if available
                return img.getAttribute('data-full-url') || img.getAttribute('data-orig-file') || img.src;
            }
            return null;
        }

        // Collect all gallery images
        function collectImages() {
            galleryImages = [];
            var seen = {};
            document.querySelectorAll('.gallery-page .wp-block-image, .gallery-lightbox-trigger, .gallery-item a').forEach(function (el) {
                var src = getImageSrc(el);
                if (src && !seen[src]) {
                    seen[src] = true;
                    var caption = el.getAttribute('data-caption') || '';
                    if (!caption) {
                        var figcaption = el.querySelector('figcaption');
                        if (figcaption) caption = figcaption.textContent;
                    }
                    galleryImages.push({ src: src, caption: caption });
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

        // Event listeners - handle clicks on gallery images
        document.addEventListener('click', function (e) {
            // Check for clicks on gallery block images, lightbox triggers, or gallery items
            var trigger = e.target.closest('.gallery-page .wp-block-image, .gallery-lightbox-trigger, .gallery-item a');
            if (trigger) {
                var src = getImageSrc(trigger);
                if (src) {
                    e.preventDefault();
                    collectImages();

                    // Find index
                    var index = galleryImages.findIndex(function (img) {
                        return img.src === src;
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
     * Division Filter Tabs (Drivers Archive)
     */
    function initDivisionTabs() {
        const tabs = document.querySelectorAll('.division-tab');
        const cards = document.querySelectorAll('.driver-card');

        if (tabs.length === 0) return;

        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                const division = this.getAttribute('data-division');

                // Update active tab
                tabs.forEach(function (t) { t.classList.remove('active'); });
                this.classList.add('active');

                // Filter driver cards
                cards.forEach(function (card) {
                    const cardDivision = card.getAttribute('data-division');
                    if (division === 'all' || cardDivision === division) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
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
        initDivisionTabs();
        initSmoothScroll();
    });

})();
