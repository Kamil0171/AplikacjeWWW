$(document).ready(function () {
    const maxWidth = 500;
    const maxClicks = 5;
    const clickStep = 20;

    const clickCounts = {};

    function handleImageClick(imageId) {
        const $image = $(`#${imageId}`);
        if (!clickCounts[imageId]) clickCounts[imageId] = 0;

        if (clickCounts[imageId] < maxClicks) {
            clickCounts[imageId]++;
            $image.stop().animate({
                width: `+=${clickStep}px`,
                height: `+=${clickStep}px`
            }, 500, "swing");
        } else {
            alert(`Obrazek osiągnął maksymalną liczbę kliknięć!`);
        }
    }

    $(".gallery-img").on("click", function () {
        handleImageClick(this.id);
    });

    $(".gallery-img").hover(
        function () {
            $(this).stop().animate({
                width: "300px",
                height: "auto"
            }, {
                duration: 1000,
                easing: "easeOutQuad"
            });
        },
        function () {
            $(this).stop().animate({
                width: "200px",
                height: "auto"
            }, {
                duration: 1000,
                easing: "easeOutQuad"
            });
        }
    );
});
