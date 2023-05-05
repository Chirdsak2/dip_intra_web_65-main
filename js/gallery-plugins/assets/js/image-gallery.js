$(function () {
    $('#aniimated-thumbnials').lightGallery({
        thumbnail: true,
        selector: '.img',
        escKey: true,
        keyPress: true,
        getCaptionFromTitleOrAlt: true
    });
});