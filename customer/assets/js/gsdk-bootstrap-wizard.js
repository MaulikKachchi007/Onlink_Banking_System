searchVisible = 0;
transparent = true;
console.log("hello");
$(document).ready(function () {
    $('#wizard-picture-error').hide();
    $('[rel="tooltip"]').tooltip();


    var $validator = $('.wizard-card form').validate({
        rules: {
            photo: {
                imgRequired: true
            },
            firstname: {
                required: true,
                minlength: 3
            },
            lastname: {
                required: true,
                minlength: 3
            },
            email: {
                itsEmail: true,
                required: true,
                minlength: 3
            },
            houseno: {
                required: true,
                itsNumber: true
            },
            locality: "required",
            area: "required",
            pincode: {
                itsPincode: true
            },
            city: "required",
            date: {
                required: true,
                validDate: true
            },
            occuption: {
                required: true,
                itsRequired: true
            },
            password: {
                required: true,
                strongPassword: true

            },
            rpwd: {
                required: true,
                equalTo: "#password",
                strongPassword: true
            },
            pin: {
                required: true,
                itsPincode: true
            },
            cpin: {
                required: true,
                itsPincode: true,
                equalTo: '#pin'
            }
        },
        messages: {
            photo: "Profile Image Required!",
            firstname: {
                required: "First Name Must Required!",
                minlength: "First Name Can't LessThen 3 Charactor!"
            },
            lastname: {
                required: 'Last Name Must Required!',
                minlength: "Email Can't LessThen 3 Charactor!"
            },
            email: {
                required: true,
                itsEmail: "Its Not Valid Email",
            },
            houseno: {
                required: "it's Required!",
                itsNumber: "it's Not a Number!"
            },
            locality: "Its Required",
            area: "Its Required",
            pincode: {
                itsPincode: "Only 6 Digits"
            },
            city: "Its Not Empty",
            date: {
                required: "DOB Required!",
                validDate: "Person Must Be 16 Year Old!"
            },
            occuption: {
                required: "Required!",
                itsRequired: "Required!"
            },
            password: {
                required: "Required!",
                strongPassword: "Password Contains 8 To 12 Alpha-Numeric With Special Charactors!"
            },
            rpwd: {
                required: "Required!",
                strongPassword: "Password Contains 8 To 12 Alpha-Numeric With Special Charactors!",
                equalTo: "Conform Password Can't Same To Password!",
            },
            pin: {
                required: "Required!",
                itsPincode: "Pin Only 6 Digits!"
            },
            cpin: {
                required: "Required!",
                itsPincode: "Verify-Pin Only 6 Digits!",
                equalTo: "Account Verify-Pin Can't Same To Account Pin!"
            }
        }
    });

    $.validator.addMethod("imgRequired", (value, element) => {
        if (value) {
            $('#photoError').hide();
            return true;
        } else {
            $('#photoError').show();
            $('#photoError').text("Image Required!");
            return false;
        }
    });

    $.validator.addMethod("itsEmail", (value, element) => {
        return /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i.test(value);
    });
    $.validator.addMethod("itsNumber", (value, element) => {
        return /^[0-9]*$/.test(value);
    });
    $.validator.addMethod("itsPincode", (value, element) => {
        return /^[0-9]{6}$/.test(value);
    });
    $.validator.addMethod("strongPassword", (value, element) => {
        var matchPassword = new RegExp(/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,12}$/);
        console.log(value.match(matchPassword), matchPassword, value);
        return value.match(matchPassword);
    });
    $.validator.addMethod("itsRequired", (value, element) => {
        return value !== "None";
    });
    $.validator.addMethod("equalTo", (value, element, parentID) => {
        console.log(value, element, parentID, $(parentID).val());
        return value === $(parentID).val();
    });
    $.validator.addMethod("validDate", (value, element) => {
        var selectedDate = new Date(value);
        var newDate = new Date();
        selectedDate.setFullYear(selectedDate.getFullYear() + 16);
        return selectedDate.getFullYear() <= newDate.getUTCFullYear();
    });

    var d = new Date();
    d.setDate(d.getDate() - 5);

    // Wizard Initialization
    $('.wizard-card').bootstrapWizard({
        'tabClass': 'nav nav-pills',
        'nextSelector': '.btn-next',
        'previousSelector': '.btn-previous',

        onNext: function (tab, navigation, index) {
            var $valid = $('.wizard-card form').valid();
            if (!$valid) {
                $validator.focusInvalid();
                return false;
            }
        },

        onInit: function (tab, navigation, index) {

            //check number of tabs and fill the entire row
            var $total = navigation.find('li').length;
            $width = 100 / $total;
            var $wizard = navigation.closest('.wizard-card');

            $display_width = $(document).width();

            if ($display_width < 600 && $total > 3) {
                $width = 50;
            }

            navigation.find('li').css('width', $width + '%');
            $first_li = navigation.find('li:first-child a').html();
            $moving_div = $('<div class="moving-tab">' + $first_li + '</div>');
            $('.wizard-card .wizard-navigation').append($moving_div);
            refreshAnimation($wizard, index);
            $('.moving-tab').css('transition', 'transform 0s');
        },

        onTabClick: function (tab, navigation, index) {

            var $valid = $('.wizard-card form').valid();

            if (!$valid) {
                return false;
            } else {
                return true;
            }
        },

        onTabShow: function (tab, navigation, index) {
            var $total = navigation.find('li').length;
            var $current = index + 1;

            var $wizard = navigation.closest('.wizard-card');

            // If it's the last tab then hide the last button and show the finish instead
            if ($current >= $total) {
                $($wizard).find('.btn-next').hide();
                $($wizard).find('.btn-finish').show();
            } else {
                $($wizard).find('.btn-next').show();
                $($wizard).find('.btn-finish').hide();
            }

            button_text = navigation.find('li:nth-child(' + $current + ') a').html();

            setTimeout(function () {
                $('.moving-tab').text(button_text);
            }, 150);

            var checkbox = $('.footer-checkbox');

            if (!index == 0) {
                $(checkbox).css({
                    'opacity': '0',
                    'visibility': 'hidden',
                    'position': 'absolute'
                });
            } else {
                $(checkbox).css({
                    'opacity': '1',
                    'visibility': 'visible'
                });
            }

            refreshAnimation($wizard, index);
        }
    });


    // Prepare the preview for profile picture
    $("#wizard-picture").change(function () {
        readURL(this);
    });

    $('[data-toggle="wizard-radio"]').click(function () {
        wizard = $(this).closest('.wizard-card');
        wizard.find('[data-toggle="wizard-radio"]').removeClass('active');
        $(this).addClass('active');
        $(wizard).find('[type="radio"]').removeAttr('checked');
        $(this).find('[type="radio"]').attr('checked', 'true');
    });

    $('[data-toggle="wizard-checkbox"]').click(function () {
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
            $(this).find('[type="checkbox"]').removeAttr('checked');
        } else {
            $(this).addClass('active');
            $(this).find('[type="checkbox"]').attr('checked', 'true');
        }
    });

    $('.set-full-height').css('height', 'auto');

});



//Function to show image before upload

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#wizardPicturePreview').attr('src', e.target.result).fadeIn('slow');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$(window).resize(function () {
    $('.wizard-card').each(function () {
        $wizard = $(this);
        index = $wizard.bootstrapWizard('currentIndex');
        refreshAnimation($wizard, index);

        $('.moving-tab').css({
            'transition': 'transform 0s'
        });
    });
});

function refreshAnimation($wizard, index) {
    total_steps = $wizard.find('li').length;
    move_distance = $wizard.width() / total_steps;
    step_width = move_distance;
    move_distance *= index;

    $wizard.find('.moving-tab').css('width', step_width);
    $('.moving-tab').css({
        'transform': 'translate3d(' + move_distance + 'px, 0, 0)',
        'transition': 'all 0.3s ease-out'

    });
}

function debounce(func, wait, immediate) {
    var timeout;
    return function () {
        var context = this, args = arguments;
        clearTimeout(timeout);
        timeout = setTimeout(function () {
            timeout = null;
            if (!immediate) func.apply(context, args);
        }, wait);
        if (immediate && !timeout) func.apply(context, args);
    };
};
