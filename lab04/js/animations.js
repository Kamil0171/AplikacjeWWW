$(document).ready(function() {
    $("#animacjaTestowal").on("click", function(){
        $(this).animate({
            width: "500px",
            opacity: 0.4,
            fontSize: "3em",
            borderWidth: "10px"
        }, 1500);
    });

    // Toggle animation for images
    $(".image-container2").on("click", function() {
        const $image = $(this);
        const isExpanded = $image.data("expanded"); // Check if image is expanded

        if (isExpanded) {
            // Return to original size
            $image.animate({
                width: "200px", // Replace with your original size
                opacity: 1
            }, 1500);
        } else {
            // Expand image
            $image.animate({
                width: "500px", // Target expanded size
                opacity: 0.8
            }, 1500);
        }

        // Toggle the expanded state
        $image.data("expanded", !isExpanded);
    });

    // Mouseover and mouseout animations for images
    $(".image-container").on({
        "mouseover": function() {
            $(this).animate({
                width: 300 ,// Adjust the target size for mouseover
                height: 300
            }, 800);
        },
        "mouseout": function() {
            $(this).animate({
                width: 200, // Adjust the original size for mouseout
                height: 200
            }, 800);
        }
    });

    // Mouseover and mouseout animations for images
    $(".image-container2").on({
        "mouseover": function() {
            $(this).animate({
                width: 300 ,// Adjust the target size for mouseover4
                height: 300
            }, 800);
        },
        "mouseout": function() {
            $(this).animate({
                width: 200, // Adjust the original size for mouseout
                height: 200
            }, 800);
        }
    });

    // Initialize the counter
    let clickCounter = 0;

    $(".image-container").on("click", function() {
        if (!$(this).is(":animated")) {
            // Increment the counter
            clickCounter++;

            if (clickCounter < 5) {
                // Animate image to grow
                $(this).animate({
                    width: "+=20",
                    height: "+=20",
                    opacity: "+=0.1"
                }, {
                    duration: 500 // Duration of animation
                });
            } else {
                // Reset image to its original size and reset counter
                $(this).animate({
                    width: "200px", // Replace with original width
                    height: "200px", // Replace with original height
                    opacity: 1 // Reset opacity
                }, {
                    duration: 500 // Duration of reset animation
                });

                clickCounter = 0; // Reset counter to zero
            }
        }
    });

});


// $(document).ready(function () {
//     const maxWidth = 500;
//     const maxClicks = 5;
//     const clickStep = 20;
//
//     const clickCounts = {};
//
//     function handleImageClick(imageId) {
//         const $image = $(`#${imageId}`);
//         if (!clickCounts[imageId]) clickCounts[imageId] = 0;
//
//         if (clickCounts[imageId] < maxClicks) {
//             clickCounts[imageId]++;
//             $image.stop().animate({
//                 width: `+=${clickStep}px`,
//                 height: `+=${clickStep}px`
//             }, 500, "swing");
//         } else {
//             alert(`Obrazek osiągnął maksymalną liczbę kliknięć!`);
//         }
//     }
//
//     $(".gallery-img").on("click", function () {
//         handleImageClick(this.id);
//     });
//
//     $(".gallery-img").hover(
//         function () {
//             $(this).stop().animate({
//                 width: "300px",
//                 height: "auto"
//             }, {
//                 duration: 1000,
//                 easing: "easeOutQuad"
//             });
//         },
//         function () {
//             $(this).stop().animate({
//                 width: "200px",
//                 height: "auto"
//             }, {
//                 duration: 1000,
//                 easing: "easeOutQuad"
//             });
//         }
//     );
// });
