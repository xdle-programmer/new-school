const $imgBlock = document.querySelector('.img-block');

if ($imgBlock) {
    imgBlockParallax();
}

function imgBlockParallax() {
    const imgBlockHeight = $imgBlock.getBoundingClientRect().height;

    const $titleBig = $imgBlock.querySelector('.img-block__title');
    const $titleSmall = $imgBlock.querySelector('.img-block__subtitle');
    const $button = $imgBlock.querySelector('.img-block__button');
    const $geometry = $imgBlock.querySelector('.img-block__geometry');

    const titleBigCoefficient = 9;
    const titleSmallCoefficient = 11;
    const buttonCoefficient = 16;
    const geometryCoefficient = 18;

    document.addEventListener('scroll', () => {
        if (window.scrollY > imgBlockHeight) {
            $titleBig.style.visibility = 'hidden';
            $titleSmall.style.visibility = 'hidden';
            $button.style.visibility = 'hidden';
            $geometry.style.visibility = 'hidden';
            return;
        }

        $titleBig.style.visibility = 'visible';
        $titleSmall.style.visibility = 'visible';
        $button.style.visibility = 'visible';
        $geometry.style.visibility = 'visible';


        if (window.scrollY === 0) {
            $titleBig.style.transform = 'none';
            $titleSmall.style.transform = 'none';
            $button.style.transform = 'none';
            $geometry.style.transform = 'none';
            return;
        }

        const shift = window.scrollY / (imgBlockHeight / 100);

        $titleBig.style.transform = `translateY(${shift * titleBigCoefficient}px)`;
        $titleSmall.style.transform = `translateY(${shift * titleSmallCoefficient}px)`;
        $button.style.transform = `translateY(${shift * buttonCoefficient}px)`;
        $geometry.style.transform = `translateY(${shift * geometryCoefficient}px)`;

        $titleBig.style.opacity = (100 - (shift * 2)) / 100;
        $titleSmall.style.opacity = (100 - (shift * 2)) / 100;
        $button.style.opacity = (100 - (shift * 2)) / 100;
        $geometry.style.opacity = (100 - (shift * 2)) / 100;

    });


}

