import {tns} from "tiny-slider";

if (document.querySelector('.slider')) {

    const $descArray = document.querySelectorAll('.slider__desc');
    const $imgArray = document.querySelectorAll('.slider__item-img-wrapper');
    let maxHeight = 0

    for (let $desc of $descArray) {
        const height = $desc.getBoundingClientRect().height

        if (height > maxHeight) {
            maxHeight = height
        }
    }

    for (let $desc of $descArray) {
        $desc.style.height = `${maxHeight}px`
    }

    for (let $img of $imgArray) {
        $img.style.height = `${maxHeight}px`
    }

    let slider = tns({
        container: '.slider',
        items: 1,
        mouseDrag: true,
        arrowKeys: true,
        controls:true,
        responsive: {
            // 640: {
            //     edgePadding: 20,
            //     gutter: 20,
            //     items: 2
            // },
            // 700: {
            //     gutter: 30
            // },
            // 900: {
            //     items: 1
            // }
        }
    });
}
