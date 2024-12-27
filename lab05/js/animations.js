$(document).ready(function() {
    $("#animacjaTestowal").on("click", function(){
        $(this).animate({
            width: "500px",
            opacity: 0.4,
            fontSize: "3em",
            borderWidth: "10px"
        }, 1500);
    });

    $(".image-container2").on("click", function() {
        const $image = $(this);
        const isExpanded = $image.data("expanded");

        if (isExpanded) {
            $image.animate({
                width: "200px",
                opacity: 1
            }, 1500);
        } else {
            $image.animate({
                width: "500px",
                opacity: 0.8
            }, 1500);
        }

        $image.data("expanded", !isExpanded);
    });

    $(".image-container").on({
        "mouseover": function() {
            $(this).animate({
                width: 300 ,
                height: 300
            }, 800);
        },
        "mouseout": function() {
            $(this).animate({
                width: 200,
                height: 200
            }, 800);
        }
    });

    $(".image-container2").on({
        "mouseover": function() {
            $(this).animate({
                width: 300 ,
                height: 300
            }, 800);
        },
        "mouseout": function() {
            $(this).animate({
                width: 200,
                height: 200
            }, 800);
        }
    });

    let clickCounter = 0;

    $(".image-container").on("click", function() {
        if (!$(this).is(":animated")) {
            clickCounter++;

            if (clickCounter < 5) {
                $(this).animate({
                    width: "+=20",
                    height: "+=20",
                    opacity: "+=0.1"
                }, {
                    duration: 500
                });
            } else {
                $(this).animate({
                    width: "200px",
                    height: "200px",
                    opacity: 1
                }, {
                    duration: 500
                });

                clickCounter = 0;
            }
        }
    });

});
