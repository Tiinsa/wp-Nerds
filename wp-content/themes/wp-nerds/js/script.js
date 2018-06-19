

var link = document.querySelector(".footer-contacts a.btn");
var popup = document.querySelector(".feedback");
var escape = document.querySelector(".feedback-circle-btn");
var login = document.querySelector("#feedback-login");
var email = document.querySelector("#feedback-email");
var textarea = document.querySelector("#feedback-textarea");
var form = popup.querySelector("form");
var storageLogin = localStorage.getItem("login", login.value);
var storageEmail = localStorage.getItem("email", email.value);


link.addEventListener("click", function(event) {
	event.preventDefault();
    popup.classList.remove("feedback-error");
    popup.classList.add("feedback-shown");
	popup.classList.add("feedback-show");
	if (storageLogin) {
        login.value = storageLogin;
        if (storageEmail) {
        	email.value = storageEmail;
        	textarea.focus();
        }
        else {
        	email.focus();
        }
    } 
    else {
        login.focus();
    }
});

escape.addEventListener("click", function(event){
	event.preventDefault();
	popup.classList.remove("feedback-shown");
});

form.addEventListener("submit", function(event){
    if (!(login.value&&email.value&&textarea.value)) {
        event.preventDefault();
        popup.classList.remove("feedback-show");
        popup.classList.remove("feedback-error");
        // void popup.offsetWidth;
        // popup.classList.add("feedback-error");
        setTimeout(function() {popup.classList.add("feedback-error");}, 10);
        // popup.classList.add("feedback-error");
        // setTimeout(function() {popup.classList.remove("feedback-error");}, 10);
    } else {
		localStorage.setItem("login", login.value);
        localStorage.setItem("email", email.value);
	}

});

window.addEventListener("keydown", function(event){
	if (event.keyCode === 27) {
		if (popup.classList.contains("feedback-shown")) {
			popup.classList.remove("feedback-shown");
		}
	}
});

// получение всех параметров из GET запроса
var params = window.location.search.replace('?','').split('&').reduce(
        function(p,e){
            var a = e.split('=');
            p[ decodeURIComponent(a[0])] = decodeURIComponent(a[1]);
            return p;
        },
        {}
    );



function initialize() {
   //var x = 59.9386115;
    //var y = 30.3235393;
    var mapOptions = {
        // zoom: 16,
         zoom: map_zoom,
        // center: new google.maps.LatLng(x+0.0005, y-0.0035),
        center: new google.maps.LatLng(x, y),
        scrollwheel: false,
        disableDefaultUI: true
    };
    var map = new  google.maps.Map(
        document.querySelector(".map-script"),
        mapOptions
    );
   //var image ="wp-content/uploads/2017/12/marker.png"; 
    var myLatLng = new google.maps.LatLng(x, y);
    var beachMarker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        icon: map_image,
        draggable: draggable,
        // title : "Youre can drag me!"
    });
    var footerContacts = document.querySelector(".footer-contacts");
    

    if (draggable) {

        beachMarker.addListener('dragend', function() {
            map.panTo(beachMarker.getPosition());
            footerContacts.style.display = 'block';
            var c = map.getCenter();
            var lat = c.lat();
            var lng = c.lng();
        // console.log('latlng', lat, lng);
            parent.postMessage({lat : lat, lng : lng, action : "setMapsCoords"},'http://wp-nerds:8080');
        });

        beachMarker.addListener('drag', function() {
            footerContacts.style.display = 'none';
        });


        beachMarker.addListener('click', function() {
            // map.setZoom(8);
            map.setCenter(beachMarker.getPosition());
           

        });

    var markerBounce = document.querySelector(".footer-maps__preview");
    
    if (markerBounce) {
        markerBounce.addEventListener('mouseover', function() {
            // console.log ('mouseover');
            beachMarker.setAnimation(google.maps.Animation.BOUNCE);
        });
        markerBounce.addEventListener('mouseout', function(e) {
            // console.log ('mouseout');
            var markerBounceCoords = markerBounce.getBoundingClientRect();
            var x = e.clientX;
            var y = e.clientY;
            if (
                x < markerBounceCoords.left || x > markerBounceCoords.right
                || y < markerBounceCoords.top || y > markerBounceCoords.bottom
            ) {
                beachMarker.setAnimation(null);
            }
        });

        beachMarker.addListener('mouseover', function() {
            // console.log ('Markermouseover');
            beachMarker.setAnimation(null);
        });
        
            // beachMarker.setAnimation(google.maps.Animation.BOUNCE);
        // $( markerBounce ).hover(
        //       function() {
        //         beachMarker.setAnimation(google.maps.Animation.BOUNCE);
        //       }, function() {
        //         beachMarker.setAnimation(null);
        //       }
// );
    };


    };
}
google.maps.event.addDomListener(window, "load", initialize);

                        
var radioButtons = document.querySelector(".radio-buttons");
var radioButtonArr = document.querySelectorAll(".greed");

jQuery(function($){

    $(document).on('click','.radio-buttons input',function(event) {
        var target = event.target;
        radioButtonArr.forEach(function(item, i, arr) {
            if (target != item) {
                $(item).prop('checked', false);
            };
        });
    });


var filter = $("#filter");

    $(document).on('change','#filter input',function(event) {
        console.log (filter.serialize());
        $('#filter').submit();
        
    });
}(jQuery))


// ************ editor
class SliderPoint {
    
    constructor(element, minValue, maxValue, value, value2, pointerWidth) {
        this.pointerWidth = pointerWidth;
        this.minValue = minValue;
        this.maxValue = maxValue;
        this.element = document.querySelector(element);
        this.seekBarToogle = this.element.querySelector('.seekBarToogle');
        this.value = value;
        this.seekBarToogle.style.left = (this.value-this.minValue)*100/(this.maxValue - this.minValue) + '%';

        this.bar = document.querySelector('.bar');
        this.bar.style.marginLeft = this.seekBarToogle.style.left;
        var self = this;
        if (value2 !== undefined) {
            this.value2 = value2;
            this.seekBarToogle2 = this.element.querySelector('.seekBarToogle2');
            this.seekBarToogle2.style.left = (this.value2-this.minValue)*100/(this.maxValue - this.minValue) + '%';

            // if (this.pointerWidth) {
            //     this.seekBarToogle2.style.marginLeft = -this.seekBarToogle2.offsetWidth + 'px';
            // }

            this.bar.style.width = (this.seekBarToogle2.getBoundingClientRect().right - this.seekBarToogle.getBoundingClientRect().right) + 'px';
            this.seekBarToogle2.addEventListener('mousedown', function(e){
              self.mouse(e,true);
            }, false);
            this.seekBarToogle2.addEventListener('touchstart', function(e){
                self.touch(e,true);
            },false);
        }

        this.seekBarToogle.addEventListener('mousedown', function(e){
              self.mouse(e,false);
        }, false);
        this.seekBarToogle.addEventListener('touchstart', function(e){
            self.touch(e,false);
        },false);   

                  

    }

    mouse(event,toogle) {
        // coords in document
        var seekBar = document.querySelector('.scale');
        var self = this;

        console.log ('rtetg');
        document.onmousemove = function(e) {
            var x = e.clientX;
         // this == document
            self.calcNewPosition(x,seekBar,toogle);
        }
    
        document.onmouseup = function() {

            document.onmousemove = document.onmouseup = null; //обнуление оработчиков;
        }
    }

    touch(event,toogle) {

        if (event.targetTouches.length == 1) { //проверяем что касание одним пальцем
            var seekBar = document.querySelector('.scale');
            var self = this;
            event.preventDefault();

            document.addEventListener('touchmove', touchMove );

            document.addEventListener('touchend', touchEnd );

            function touchMove(e) {
                var touch = e.targetTouches[0];
                var x = touch.clientX;
                self.calcNewPosition(x,seekBar,toogle);
            }

            function touchEnd(e) {
                //когда отпустили кнопку мыши обнуляем обработчики
                document.removeEventListener('touchmove', touchMove);
                document.removeEventListener('touchend', touchEnd);
            };
        };
    }

    calcNewPosition(x,seekBar,toogle) {
        var seekBarCoords = seekBar.getBoundingClientRect();
        var seekBarToogle2Coords = this.seekBarToogle2.getBoundingClientRect();
        var seekBarToogleCoords = this.seekBarToogle.getBoundingClientRect();
        var seekBarLeft = seekBarCoords.left;
        var seekBarRight = seekBarCoords.right;
               
        if (!toogle && (this.value2!== undefined)) {
            var seekBarRight = seekBarToogle2Coords.left + this.seekBarToogle2.offsetWidth*0.5;
            // if (this.pointerWidth) {
            //     var seekBarRight = seekBarToogle2Coords.left - this.seekBarToogle.offsetWidth;
            // }
       
        } else if (toogle && (this.value2!== undefined)) {
            var seekBarLeft = seekBarToogleCoords.left + this.seekBarToogle.offsetWidth*0.5;
            // if (this.pointerWidth) {
            //     var seekBarLeft = seekBarToogleCoords.left + this.seekBarToogle.offsetWidth + this.seekBarToogle2.offsetWidth;
            // }
        }

        x = Math.max(x,seekBarLeft);
        x = Math.min(x,seekBarRight);
        // console.log (seekBarLeft,seekBarRight,x);
        x = x - seekBarCoords.left;
        var progress = Math.round((x*100)/seekBar.offsetWidth);
        
        if (!toogle) {
            this.seekBarToogle.style.left = progress + '%';
            this.bar.style.marginLeft = this.seekBarToogle.style.left;
            // if (this.pointerWidth) {
            //     this.seekBarToogle.style.left = 'auto';
            //     this.seekBarToogle.style.right = (100 - progress) + '%';
            //     this.bar.style.marginLeft = this.seekBarToogle.style.left;
            // }
            this.value = Math.round(
                (progress*(this.maxValue - this.minValue))/100 + this.minValue
            );
           
        } else {
            this.seekBarToogle2.style.left = progress + '%';
            this.value2 = Math.round(
                (progress*(this.maxValue - this.minValue))/100 + this.minValue
            );
        }
        this.bar.style.width = (seekBarToogle2Coords.left - seekBarToogleCoords.left) + 'px';
        var event = new Event("change");
        this.element.dispatchEvent(event);
    };

        
    getValue() {
        return this.value;
    }

    getValue2() {
        return this.value2;
    }

    setValue(value) {
        this.value = value;
        this.seekBarToogle.style.left =Math.max(Math.round((this.value-this.minValue)*100)/(this.maxValue - this.minValue), 0) + '%';
        this.bar.style.marginLeft = this.seekBarToogle.style.left;
    };

    setValue2(value2) {
        this.value2 = value2;
        this.seekBarToogle2.style.left = Math.min(Math.round((this.value2-this.minValue)*100)/(this.maxValue - this.minValue), 100) + '%';
        this.bar.style.width = (this.seekBarToogle2.getBoundingClientRect().right - this.seekBarToogle.getBoundingClientRect().right) + 'px';
    }

    init() {

        var minPrice = document.querySelector('.min-price');
        var maxPrice = document.querySelector('.max-price');
        var maxP = document.getElementById('max-p');
        var minP = document.getElementById('min-p');
        var self = this;
        
        elementObj1.addEventListener('change', function(event) {
            
            minP.value = self.getValue();
            maxP.value = self.getValue2();
        });

        minPrice.addEventListener('change', function(event) {
            self.setValue(minP.value);
        });

        self.setValue(minP.value);


        maxPrice.addEventListener('change', function(event) {
            self.setValue2(maxP.value);
        });

        self.setValue2(maxP.value);
    }
};

// var editor = document.querySelector('.range-controls');
// if (editor) {

//     var element = '.scale';
//     var elementObj1 = document.querySelector(element);
//     var slider1 = new SliderPoint(element, 0, 100000, 1000, 50000, true);
//     slider1.init();
   

// };


// var slides = document.querySelector('.slider');
//                             slides.addEventListener('click', function(event){
//                                 console.log ('slides');
                                
//                                 // wp.customize.panel( 'panel_slider' ).focus();
//                                 // console.log (event.target.value);
//                                 if (event.target.value == 'slide-one') {
//                                     parent.postMessage({action : "slide-one"},'http://wp-nerds:8080');
//                                     // wp.customize.section( 'tcx_slide_1_options' ).focus();
//                                 } else if (event.target.value == 'slide-two') {
//                                     parent.postMessage({action : "slide-two"},'http://wp-nerds:8080');
//                                     // wp.customize.section( 'tcx_slide_2_options' ).focus();
//                                 } else if (event.target.value == 'slide-three') {
//                                     parent.postMessage({action : "slide-three"},'http://wp-nerds:8080');
//                                     // wp.customize.section( 'tcx_slide_3_options' ).focus();
//                                 } else {
//                                     return;
//                                 }
                                
//                             });


