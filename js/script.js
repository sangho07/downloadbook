
        // Lấy tham chiếu đến biểu tượng đóng form bằng cách sử dụng id
        var closeButtonRegister = document.getElementById("btn-close-register");
        var closeButtonLogin = document.getElementById("btn-close-login");

        // Lấy tham chiếu đến div chứa form đăng ký và form đăng nhập
        var registerForm = document.getElementById("register");
        var loginForm = document.getElementById("login");

        // Thêm sự kiện click cho biểu tượng đóng form đăng ký
        if (closeButtonRegister) {
            closeButtonRegister.addEventListener("click", function (event) {
                event.preventDefault();
                registerForm.style.display = "none";
            });
        }

        // Thêm sự kiện click cho biểu tượng đóng form đăng nhập
        if (closeButtonLogin) {
            closeButtonLogin.addEventListener("click", function (event) {
                event.preventDefault();
                loginForm.style.display = "none";
            });
        }


// Swiper
var swiper = new Swiper(".books-list", {
   
    loop:true,
    centeredSlides:true,
    autoplay:{
        delay:9500,
        disableOnInteraction:false,
    },
    breakpoints: {
     0: {
        slidesPerView: 1,   
      },
      768: {
        slidesPerView: 2, 
      },
      1024: {
        slidesPerView: 3, 
      },
    },
  });

