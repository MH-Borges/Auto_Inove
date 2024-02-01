document.addEventListener( 'DOMContentLoaded', function() {
    var swiper = new Swiper(".swiper", {
        centeredSlides: true,
        autoplay: {
            delay: 3500,
            disableOnInteraction: false,
        },
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
        pagination: {
          el: ".swiper-pagination",
          type: "progressbar",
        },
    });

    function mobileCheck() {
      let check = false;
      (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
      return check;
    };

    function createStar(size, className) {
      var star = document.createElement("div");
      var xPos = Math.random() * 100;
      var yPos = Math.random() * 100;
  
      star.style.position = "absolute";
      star.style.top = yPos > 98 ? "96%" : yPos + "%";
      star.style.left = xPos > 92 ? "85%" : xPos + "%";
  
      if (className === "blinking-star") {
        star.style.height = size + "px";
        star.style.width = size + "px";
        star.style.backgroundColor = "#ffffff";
        star.style.borderRadius = "50%";
      } else {
        star.style.fontSize = size + "vw";
      }
  
      document.body.appendChild(star);
      star.classList.add(className);
      setTimeout(() => { star.remove(); }, 1750);
    }
  
    function blinkingStars() { createStar(Math.random() * 7, "blinking-star"); }
    function Stars() { createStar(Math.random() * 1.35, "star"); }

    if(mobileCheck() == true){
      document.querySelector('.icons_Links').innerHTML= '<a href="https://google.com" target="_blank"><img src="assets/icones/Instagram.svg" onload="SVGInject(this)"></a><a href="https://google.com" target="_blank"><img src="assets/icones/WhatsApp.svg" onload="SVGInject(this)"></a>';
      document.querySelector('.swiper').remove();
      document.querySelector('.BackgroundLinks').remove();

      let imgGalaxia = document.createElement('img');
      imgGalaxia.src ='assets/galaxia.webp';
      imgGalaxia.alt ='background';
      imgGalaxia.classList.add('galaxiaBack');
      document.querySelector('.main').appendChild(imgGalaxia);

      let imgFarol = document.createElement('img');
      imgFarol.src ='assets/farol.webp';
      imgFarol.alt ='background';
      imgFarol.classList.add('farolBack');
      document.querySelector('.main').appendChild(imgFarol);

      setInterval(blinkingStars, 30);
      setInterval(Stars, 15);
    }
    else{
      document.querySelector('.mobileBanner').remove();
      setInterval(blinkingStars, 75);
      setInterval(Stars, 50);
    }
} );