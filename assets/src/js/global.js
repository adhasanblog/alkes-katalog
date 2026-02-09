import {initMobileMenu} from "./modules/header/mobile-menu";
import {initHeaderAnimate} from "./modules/header/header-animate";
import {initHeroProductRotator} from "./modules/hero/hero-product";
import {initSidebarCategories} from "./modules/sidebar";
import {initTabs} from "./modules/tabs";
import {initProductGallery} from "./modules/product-gallery";
import {initNavSearch} from "./modules/header/search-bar";
import {initGalleryLightbox} from "./modules/gallery-lightbox";
import {initCTAHandler} from "./modules/cta-handler";
import {initFaqAccordion} from "./modules/faq";


console.log("Vite loaded");

function init() {
    initMobileMenu();
    initHeaderAnimate();
    initHeroProductRotator();
    initSidebarCategories();
    initTabs()
    initProductGallery()
    initNavSearch()
    initGalleryLightbox()
    initCTAHandler()
    initFaqAccordion()

}

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
} else {
    init();
}
