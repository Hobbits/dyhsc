function getEventObject(W3CEvent) {            //事件标准化函数
    return W3CEvent || window.event;
}


function getPointerPosition(e) {            //兼容浏览器的鼠标x,y获得函数
    e = e || getEventObject(e);
    var x = e.pageX || (e.clientX + (document.documentElement.scrollLeft || document.body.scrollLeft));
    var y = e.pageY || (e.clientY + (document.documentElement.scrollTop || document.body.scrollTop));
   
    return { 'x':x,'y':y };
}

function setOpacity(elem,level) {            //兼容浏览器设置透明值
    if(elem.filters) {
        elem.style.filter = 'alpha(opacity=' + level * 100 + ')';
    } else {
        elem.style.opacity = level;
    }
}

function css(elem,prop) {                //css设置函数,方便设置css值,并且兼容设置透明值
    for(var i in prop) {
        if(i == 'opacity') {
            setOpacity(elem,prop[i]);
        } else {
            elem.style[i] = prop[i];
        }
    }
    return elem;
}

var magnifier = {
    m : null,
   
    init:function(magni){
        var m = this.m = magni || {
            cont : null,        //装载原始图像的div
            img : null,            //放大的图像
            mag : null,            //放大框
            scale : 3            //比例值,设置的值越大放大越大,但是这里有个问题就是如果不可以整除时,会产生些很小的白边,目前不知道如何解决
        }
       
        css(m.img,{   
            'position' : 'absolute',
            'width' : (m.cont.clientWidth * m.scale) + 'px',                //原始图像的宽*比例值   
            'height' : (m.cont.clientHeight * m.scale) + 'px'                //原始图像的高*比例值
            })
       
        css(m.mag,{
            'display' : 'none',
            'width' : m.cont.clientWidth + 'px',            //m.cont为原始图像,与原始图像等宽
            'height' : m.cont.clientHeight + 'px',
            'position' : 'absolute',
            'left' : m.cont.offsetLeft + m.cont.offsetWidth + 10 + 'px',        //放大框的位置为原始图像的右方远10px
            'top' : m.cont.offsetTop + 'px'
            })
       
        var borderWid = m.cont.getElementsByTagName('div')[0].offsetWidth - m.cont.getElementsByTagName('div')[0].clientWidth;        //获取border的宽
       
        css(m.cont.getElementsByTagName('div')[0],{            //m.cont.getElementsByTagName('div')[0]为浏览框
            'display' : 'none',                                //开始设置为不可见
            //'width' : m.cont.clientWidth / m.scale - borderWid + 'px',           //原始图片的宽/比例值 - border的宽度
            //'height' : m.cont.clientHeight / m.scale - borderWid + 'px',        //原始图片的高/比例值 - border的宽度
			'width' :  '100px',            //原始图片的宽/比例值 - border的宽度
            'height' : '100px',         //原始图片的高/比例值 - border的宽度
            'opacity' : 0.5                    //设置透明度
            })
       
        m.img.src = m.cont.getElementsByTagName('img')[0].src;            //让原始图像的src值给予放大图像
        m.cont.style.cursor = 'crosshair';       
        m.cont.onmouseover = magnifier.start;
       
    },
   
    start:function(e){
       
        if(document.all){                //只在IE下执行,主要避免IE6的select无法覆盖
            magnifier.createIframe(magnifier.m.img);
        }
       
        this.onmousemove = magnifier.move;        //this指向m.cont
        this.onmouseout = magnifier.end;
    },
   
    move:function(e){
        var pos = getPointerPosition(e);        //事件标准化
       
        this.getElementsByTagName('div')[0].style.display = '';				
       
        css(this.getElementsByTagName('div')[0],{
            'top' : Math.min(Math.max(pos.y - this.offsetTop - parseInt(this.getElementsByTagName('div')[0].style.height) / 2,0),this.clientHeight - this.getElementsByTagName('div')[0].offsetHeight) + 'px',
            'left' : Math.min(Math.max(pos.x - this.offsetLeft - parseInt(this.getElementsByTagName('div')[0].style.width) / 2,0),this.clientWidth - this.getElementsByTagName('div')[0].offsetWidth) + 'px'            
            })
        
        magnifier.m.mag.style.display = '';
       
        css(magnifier.m.img,{
            'top' : - (parseInt(this.getElementsByTagName('div')[0].style.top) * magnifier.m.scale) + 'px',
            'left' : - (parseInt(this.getElementsByTagName('div')[0].style.left) * magnifier.m.scale) + 'px'
            })
       
    },
   
    end:function(e){
        this.getElementsByTagName('div')[0].style.display = 'none';
        magnifier.removeIframe(magnifier.m.img);        //销毁iframe
       
        magnifier.m.mag.style.display = 'none';
    },
   
    createIframe:function(elem){
        var layer = document.createElement('iframe');
        layer.tabIndex = '-1';
        layer.src = 'javascript:false;';
        elem.parentNode.appendChild(layer);
       
        layer.style.width = elem.offsetWidth + 'px';
        layer.style.height = elem.offsetHeight + 'px';
				
    },
   
    removeIframe:function(elem){
        var layers = elem.parentNode.getElementsByTagName('iframe');
        while(layers.length >0){
            layers[0].parentNode.removeChild(layers[0]);
        }
    }
}

