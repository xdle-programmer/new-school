import {tns} from "tiny-slider";

if (document.querySelector('.slider')) {
    let slider = tns({
        container: '.slider',
        items: 1,
        mouseDrag: true,
        arrowKeys: false,
        controls:false,
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
