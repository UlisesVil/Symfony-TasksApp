'use strict'

function randomBackground(){
    let randomNumber=Math.floor(Math.random()*Math.floor(4));
   
    switch(randomNumber){
    case 0: 
        $('body').attr('style',"background: url('https://elite.luxvt.com/wp-content/uploads/2020/04/Zoom_BG9_Stylish-Living-Room.jpg');");
        $('body').css({'background-attachment':'fixed', 'background-size':'cover','background-position': 'center' });
    break;
    case 1: 
        $('body').attr('style',"background: url('https://images.pexels.com/photos/2883049/pexels-photo-2883049.jpeg');");
        $('body').css({'background-attachment':'fixed', 'background-size':'cover','background-position': 'center' });
    break;
    case 2: 
        $('body').attr('style',"background: url('https://images.pexels.com/photos/667838/pexels-photo-667838.jpeg');");
        $('body').css({'background-attachment':'fixed', 'background-size':'cover','background-position': 'center' });
    break;
    case 3: 
        $('body').attr('style',"background: url('https://images.pexels.com/photos/3968061/pexels-photo-3968061.jpeg');");
        $('body').css({'background-attachment':'fixed', 'background-size':'cover','background-position': 'center' });
    break;
    }
}
window.addEventListener('load',randomBackground);