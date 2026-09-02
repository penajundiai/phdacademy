const track=document.getElementById("track"), dots=document.getElementById("dots");
let page=0;
function cards(){return [...track.querySelectorAll(".event")]}
function perView(){if(innerWidth<=640)return 1;if(innerWidth<=1000)return 2;return 3}
function pages(){return Math.max(1,Math.ceil(cards().length/perView()))}
function renderDots(){
  dots.innerHTML="";
  if(cards().length===0)return;
  for(let i=0;i<pages();i++){
    const b=document.createElement("button");
    b.className="dot"+(i===page?" active":"");
    b.onclick=()=>{page=i;move();renderDots()};
    dots.appendChild(b)
  }
}
function move(){
  const c=cards()[0]; if(!c)return;
  if(page>pages()-1)page=pages()-1;
  track.style.transform=`translateX(-${page*(c.getBoundingClientRect().width+18)*perView()}px)`
}
const n=document.getElementById("next"),p=document.getElementById("prev");
if(n)n.onclick=()=>{page=(page+1)%pages();move();renderDots()};
if(p)p.onclick=()=>{page=(page-1+pages())%pages();move();renderDots()};
addEventListener("resize",()=>{page=0;renderDots();move()});
const menu=document.getElementById("menu"), btn=document.getElementById("menuBtn");
if(btn)btn.onclick=()=>menu.classList.toggle("mobile-open");
renderDots(); move();

// Microanimações de entrada no scroll
const revealItems = document.querySelectorAll(".reveal");
if ("IntersectionObserver" in window) {
  const revealObserver = new IntersectionObserver((entries, obs) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add("is-visible");
        obs.unobserve(entry.target);
      }
    });
  }, { threshold: 0.12 });
  revealItems.forEach(el => revealObserver.observe(el));
} else {
  revealItems.forEach(el => el.classList.add("is-visible"));
}


// ===== V8: MOVIMENTO GARANTIDO VIA JAVASCRIPT =====
(function(){
  const strip = document.querySelector(".strip");
  const wrap = document.querySelector(".strip-wrap");
  const chevron = document.querySelector(".strip-chevron");
  const movingArrow = document.querySelector(".motion-arrow");
  const ring = document.querySelector(".hero-ring");
  const heroCircle = document.querySelector(".hero");
  const particles = [...document.querySelectorAll(".hero-particles span")];

  let marqueeX = 0;
  let last = performance.now();
  let angle = 0;
  let arrowX = -80;

  function frame(now){
    const dt = Math.min((now-last)/1000, .05);
    last = now;

    // Marquee: movement always visible
    if(wrap){
      const half = wrap.scrollWidth / 2;
      marqueeX -= 78 * dt;
      if(half > 0 && Math.abs(marqueeX) >= half) marqueeX = 0;
      wrap.style.transform = `translate3d(${marqueeX}px,0,0)`;
    }

    // Logo-inspired arrow travels across yellow strip
    if(strip && movingArrow){
      arrowX += 115 * dt;
      const limit = strip.clientWidth + 100;
      if(arrowX > limit) arrowX = -90;
      movingArrow.style.transform = `translate3d(${arrowX}px,-50%,0)`;
    }

    // Rotating chevron / arrow geometry
    if(chevron){
      const pulse = 1 + Math.sin(now/520)*0.06;
      const opacity = .20 + (Math.sin(now/520)+1)*.09;
      chevron.style.transform = `translateY(-50%) rotate(${45 + Math.sin(now/1000)*8}deg) scale(${pulse})`;
      chevron.style.opacity = opacity.toFixed(2);
    }

    // Hero orbiting ring
    angle += 24 * dt;
    if(ring){
      ring.style.transform = `rotate(${angle}deg)`;
    }

    // Floating dots
    particles.forEach((p,i)=>{
      const y = Math.sin(now/700 + i*1.7) * (8 + i*2);
      const x = Math.cos(now/1050 + i) * 4;
      const scale = 1 + Math.sin(now/850 + i)*.16;
      const opacity = .45 + (Math.sin(now/650 + i)+1)*.22;
      p.style.transform = `translate3d(${x}px,${y}px,0) scale(${scale})`;
      p.style.opacity = opacity.toFixed(2);
    });

    // Subtle rotating large hero circle
    if(heroCircle){
      const pseudoAngle = (now/90)%360;
      heroCircle.style.setProperty("--hero-rot", pseudoAngle + "deg");
    }

    requestAnimationFrame(frame);
  }

  requestAnimationFrame(frame);
})();
