<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Ultimate Luxury Pendulum Clock</title>
<script src="https://cdn.tailwindcss.com"></script>
<style>
  body {
    background: #f1f5f9;
  }

  /* Clock case */
  .clock-case {
    position: relative;
    width: 140px;
    height: 350px; /* 2.5x width */
    background: linear-gradient(to bottom, #7c3aed, #5b21b6);
    border-radius: 20px;
    border: 4px solid #4c1d95;
    box-shadow: 0 10px 25px rgba(0,0,0,0.5);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  /* Top hinge */
  .clock-top {
    width: 100%;
    height: 50px;
    background: linear-gradient(to bottom, #d8b4fe, #7c3aed);
    border-radius: 16px 16px 0 0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-weight: 600;
    text-shadow: 0 2px 4px rgba(0,0,0,0.4);
  }

  /* Digital display */
  .digital {
    margin-top: 6px;
    font-family: monospace;
    font-weight: 600;
    color: #fef3c7;
    text-shadow: 0 1px 2px rgba(0,0,0,0.4);
  }

  /* Numbers inside case */
  .number {
    position: absolute;
    font-weight: bold;
    color: #fef3c7;
    text-shadow: 0 1px 2px rgba(0,0,0,0.5);
  }

  /* Pendulum rod */
  .pendulum {
    width: 6px;
    height: 120px;
    background: linear-gradient(to bottom, #facc15, #b45309);
    border-radius: 3px;
    transform-origin: top center;
    position: absolute;
    top: 0;
    left: 50%;
    box-shadow: 0 4px 8px rgba(0,0,0,0.4);
  }

  /* Pendulum weight */
  .weight {
    width: 32px;
    height: 32px;
    background: radial-gradient(circle at 30% 30%, #fbbf24, #b45309);
    border-radius: 50%;
    position: absolute;
    bottom: -16px;
    left: 50%;
    transform: translateX(-50%);
    box-shadow: 0 4px 12px rgba(0,0,0,0.6);
  }

  /* Minute markers */
  .minute-dot {
    width: 2px;
    height: 2px;
    background: #fef3c7;
    border-radius: 50%;
    position: absolute;
    opacity: 0.6;
  }

  /* Glass reflection animation */
  .glass-reflect {
    position: absolute;
    width: 100%;
    height: 100%;
    top:0;
    left:0;
    background: linear-gradient(120deg, rgba(255,255,255,0.25), transparent 50%, rgba(255,255,255,0.15));
    pointer-events: none;
    transform: translateX(-150%);
    animation: glare 3s infinite linear;
  }

  @keyframes glare {
    0% { transform: translateX(-150%); }
    100% { transform: translateX(150%); }
  }
</style>
</head>
<body class="flex items-center justify-center min-h-screen">

<!-- Ultimate Luxury Pendulum Home Clock -->
<div class="clock-case">

  <!-- Glass Reflection -->
  <div class="glass-reflect rounded-2xl"></div>

  <!-- Top Hinge -->
  <div class="clock-top">Home Clock</div>

  <!-- Digital Time -->
  <div id="digital" class="digital text-sm">--:--:--</div>

  <!-- Numbers (12,3,6,9) -->
  <div class="number" style="top:70px; left:50%; transform: translateX(-50%);">12</div>
  <div class="number" style="top:170px; right:8px;">3</div>
  <div class="number" style="bottom:70px; left:50%; transform: translateX(-50%);">6</div>
  <div class="number" style="top:170px; left:8px;">9</div>

  <!-- Minute Markers -->
  <script>
    const clock = document.querySelector('.clock-case');
    const clockHeight = 350;
    const topOffset = 50; // below hinge
    const bottomOffset = 16; // above bottom

    for(let i=0; i<60; i++){
      const dot = document.createElement('div');
      dot.className = 'minute-dot';
      const y = topOffset + (clockHeight - topOffset - bottomOffset) * i / 59;
      dot.style.top = y + 'px';
      // Alternate placement left and right
      dot.style.left = i % 2 === 0 ? '8px' : 'calc(100% - 10px)';
      clock.appendChild(dot);
    }
  </script>

  <!-- Pendulum Rod -->
  <div id="pendulum" class="pendulum">
    <div class="weight"></div>
  </div>

</div>

<script>
    const pendulum = document.getElementById('pendulum');
    const digital = document.getElementById('digital');

    // Smooth sinusoidal swing
    function swing(time){
    const maxAngle = 30; // max swing
    const angle = maxAngle * Math.sin(time / 600); // smooth pendulum
    pendulum.style.transform = `rotate(${angle}deg)`;
    requestAnimationFrame(swing);
    }

    // Digital time update
    function updateDigital() {
    const now = new Date();
    const h = String(now.getHours()).padStart(2,'0');
    const m = String(now.getMinutes()).padStart(2,'0');
    const s = String(now.getSeconds()).padStart(2,'0');
    digital.textContent = `${h}:${m}:${s}`;
    setTimeout(updateDigital, 500);
    }

    requestAnimationFrame(swing);
    updateDigital();
</script>

</body>
</html>
