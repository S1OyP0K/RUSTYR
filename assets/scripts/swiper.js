const popularSwiper = new Swiper(".popular-swiper", {
    slidesPerView: "auto",
    spaceBetween: 10,

    breakpoints: {
        1180: {
            slidesPerView: 3,
        }
    }
})


const blogSwiper = new Swiper(".blog__swiper", {
    slidesPerView: "auto",
    spaceBetween: 24,



    breakpoints: {
        1060: {
            grid: {
                rows: 2,
            },
            slidesPerView: 2,
        }
    }
})