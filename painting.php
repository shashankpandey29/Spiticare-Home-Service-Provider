<?php
// painting.php - SpitiCare Painting Services Page
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<title>SpitiCare - Painting</title>
<style>
:root{--primary-color:#5d3b66;--secondary-color:#8e44ad;--accent-color:#ff6b6b;--accent-2:#ff9f43;--text-color:#2d3748;--light-gray:#f8f9fa;--medium-gray:#e2e8f0;--dark-gray:#4a5568;--gradient-1:linear-gradient(135deg,#5d3b66 0%,#8e44ad 100%);--gradient-2:linear-gradient(135deg,#ff6b6b 0%,#ff9f43 100%);--shadow:0 10px 30px rgba(0,0,0,.1);--shadow-hover:0 15px 35px rgba(0,0,0,.15)}
*{box-sizing:border-box;margin:0;padding:0;font-family:'Poppins',sans-serif}
body{background:#f5f7fa;color:var(--text-color);line-height:1.6;overflow-x:hidden}
.container{display:flex;padding:30px;gap:20px;max-width:1400px;margin:0 auto}
.header{display:flex;justify-content:space-between;align-items:center;padding:15px 40px;background:#fff;color:#000;box-shadow:0 5px 15px rgba(0,0,0,.1);position:fixed;top:0;left:0;width:100%;z-index:1000;transition:all .3s ease}
.header.scrolled{padding:10px 40px;box-shadow:0 5px 20px rgba(0,0,0,.15)}
.header a,.header nav ul li a{color:#000!important;text-decoration:none;font-weight:500;transition:color .3s ease}
.header a:hover{color:#ff6600}
.header nav ul li a{position:relative;padding-bottom:3px}
.header nav ul li a::after{content:"";position:absolute;left:0;bottom:0;width:0%;height:2px;background:#ff6600;transition:width .3s ease}
.header nav ul li a:hover::after{width:100%}
.center-section{flex-grow:1;display:flex;justify-content:center}
.location-selector{display:flex;align-items:center;gap:8px;background:white;padding:10px 16px;border-radius:30px;box-shadow:0 4px 12px rgba(0,0,0,.08);cursor:pointer;transition:all .3s ease;border:1px solid var(--medium-gray)}
.location-selector:hover{box-shadow:0 6px 16px rgba(0,0,0,.12);transform:translateY(-2px)}
#location-name{font-size:15px;font-weight:500;color:var(--text-color);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:200px}
.dropdown-arrow{font-size:14px;color:var(--dark-gray);transition:transform .3s ease}
.location-selector:hover .dropdown-arrow{transform:rotate(180deg)}
.right-section{display:flex;align-items:center;gap:25px}
.nav-links{list-style:none;display:flex;gap:25px;margin:0;padding:0}
.nav-links li a{text-decoration:none;color:var(--primary-color);font-weight:600;font-size:16px;position:relative;transition:color .3s ease}
.nav-links li a::after{content:'';position:absolute;bottom:-5px;left:0;width:0;height:2px;background:var(--gradient-2);transition:width .3s ease}
.nav-links li a:hover{color:var(--accent-color)}
.nav-links li a:hover::after{width:100%}
.main-content{margin-left:270px;padding:20px;margin-top:80px}
.left-panel{position:fixed;top:100px;left:20px;width:250px;background:#fff;border-radius:15px;padding:20px;box-shadow:var(--shadow);z-index:100;max-height:calc(100vh - 120px);overflow-y:auto;transition:all .3s ease}
.left-panel h3{margin-bottom:20px;font-size:20px;color:var(--primary-color);font-weight:600;text-align:center;position:relative;padding-bottom:10px}
.left-panel h3::after{content:'';position:absolute;bottom:0;left:50%;transform:translateX(-50%);width:50px;height:3px;background:var(--gradient-1);border-radius:2px}
.service-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:15px}
.service-item{display:flex;flex-direction:column;align-items:center;text-align:center;padding:15px 10px;border-radius:12px;transition:all .3s ease;cursor:pointer;position:relative;overflow:hidden}
.service-item::before{content:'';position:absolute;top:0;left:0;width:100%;height:100%;background:var(--gradient-1);opacity:0;transition:opacity .3s ease;z-index:0}
.service-item:hover::before{opacity:.1}
.service-item:hover{transform:translateY(-5px);box-shadow:0 8px 15px rgba(0,0,0,.1)}
.service-item img.side-icon{width:60px;height:60px;object-fit:cover;border-radius:10px;transition:all .3s ease;position:relative;z-index:1}
.service-item:hover img.side-icon{transform:scale(1.1)}
.service-item span{font-size:13px;margin-top:8px;font-weight:500;color:var(--dark-gray);transition:color .3s ease;position:relative;z-index:1}
.service-item:hover span{color:var(--primary-color)}
.right-panel{flex-grow:1}
.service-gridd{padding:20px 0 30px}
.service-gridd h1{font-size:32px;font-weight:700;color:var(--primary-color);margin-bottom:10px;position:relative;display:inline-block}
.service-gridd h1::after{content:'';position:absolute;bottom:-8px;left:0;width:80px;height:4px;background:var(--gradient-2);border-radius:2px}
.banner{display:flex;justify-content:space-between;align-items:center;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);border-radius:20px;overflow:hidden;padding:30px;margin-bottom:25px;box-shadow:var(--shadow);transition:all .3s ease;position:relative}
.banner::before{content:'';position:absolute;top:-50%;right:-10%;width:300px;height:300px;background:rgba(255,255,255,.05);border-radius:50%}
.banner:hover{transform:translateY(-5px);box-shadow:var(--shadow-hover)}
.banner-text{max-width:60%;position:relative;z-index:1}
.banner-text h2{font-size:26px;margin-bottom:10px;color:#fff;font-weight:700}
.banner-text .tag{display:inline-block;background:#ff6b6b;color:white;font-size:13px;padding:5px 14px;border-radius:20px;margin-bottom:12px;font-weight:600}
.banner-text p{color:rgba(255,255,255,.85);font-size:14px}
.banner-img{width:220px;height:180px;object-fit:cover;border-radius:15px;box-shadow:0 10px 30px rgba(0,0,0,.3);transition:all .3s ease;position:relative;z-index:1}
.banner:hover .banner-img{transform:scale(1.05) rotate(2deg)}
.service-section{margin-bottom:40px}
.service-section h1{font-size:28px;font-weight:600;color:var(--primary-color);margin-bottom:20px;padding-bottom:10px;border-bottom:2px solid var(--medium-gray)}
.service-card{background:white;border:1px solid var(--medium-gray);border-radius:15px;padding:20px;margin-bottom:20px;display:flex;justify-content:space-between;align-items:center;box-shadow:0 5px 15px rgba(0,0,0,.05);transition:all .3s ease;position:relative;overflow:hidden}
.service-card::before{content:'';position:absolute;top:0;left:0;width:5px;height:100%;background:var(--gradient-1);transform:scaleY(0);transition:transform .3s ease}
.service-card:hover::before{transform:scaleY(1)}
.service-card:hover{transform:translateY(-5px);box-shadow:var(--shadow-hover)}
.service-info{flex:1;margin-right:20px}
.service-info h2{margin:0;font-size:18px;font-weight:600;color:var(--text-color);margin-bottom:8px}
.rating{color:#f39c12;font-size:14px;margin:5px 0;display:flex;align-items:center}
.rating i{margin-right:3px}
.price{font-weight:600;font-size:16px;margin-bottom:8px;color:var(--accent-color)}
.desc{font-size:14px;color:var(--dark-gray);margin-bottom:8px}
.view-link{display:inline-block;font-size:14px;color:var(--primary-color);text-decoration:none;transition:all .3s ease}
.view-link:hover{color:var(--secondary-color);text-decoration:underline}
.service-image{text-align:center;min-width:110px}
.service-image img{width:90px;height:90px;object-fit:cover;margin:0 auto 10px;border-radius:12px;display:block;box-shadow:0 4px 12px rgba(0,0,0,.15);transition:all .3s ease}
.service-card:hover .service-image img{transform:scale(1.08);box-shadow:0 8px 20px rgba(0,0,0,.2)}
.add-button{padding:10px 20px;background:var(--gradient-1);color:white;border:none;border-radius:25px;cursor:pointer;font-size:14px;font-weight:500;transition:all .3s ease;box-shadow:0 4px 8px rgba(93,59,102,.3)}
.add-button:hover{transform:translateY(-3px);box-shadow:0 6px 12px rgba(93,59,102,.4)}
.options{font-size:12px;color:var(--dark-gray);margin-top:5px}
.modal{display:none;position:fixed;z-index:2000;left:0;top:0;width:100%;height:100%;overflow:auto;background:rgba(0,0,0,.6);animation:fadeIn .3s ease}
@keyframes fadeIn{from{opacity:0}to{opacity:1}}
.modal-content{background:white;margin:5% auto;padding:30px;border-radius:15px;width:90%;max-width:600px;position:relative;box-shadow:0 15px 35px rgba(0,0,0,.2);animation:slideIn .3s ease}
@keyframes slideIn{from{transform:translateY(-50px);opacity:0}to{transform:translateY(0);opacity:1}}
.modal-hero{width:100%;height:160px;object-fit:cover;border-radius:10px;margin-bottom:20px}
.close-btn{position:absolute;right:20px;top:15px;font-size:24px;font-weight:bold;color:var(--dark-gray);cursor:pointer;transition:all .3s ease;width:35px;height:35px;display:flex;align-items:center;justify-content:center;border-radius:50%;z-index:10}
.close-btn:hover{color:white;background:var(--accent-color);transform:rotate(90deg)}
.modal-content h2{margin-bottom:10px;font-size:24px;color:var(--primary-color);font-weight:600}
.modal-content p{color:var(--dark-gray);margin-bottom:20px;font-size:16px}
.process-section{background:#f8f9fa;padding:20px;margin-top:20px;border-radius:12px;border-left:4px solid var(--primary-color)}
.process-section h2{font-size:20px;margin-bottom:15px;color:var(--primary-color)}
.process-step{padding:12px 0;border-bottom:1px solid var(--medium-gray);color:var(--text-color)}
.process-step:last-child{border-bottom:none}
.process-step strong{color:var(--primary-color);font-size:16px;display:block;margin-bottom:5px}
.modal-footer{text-align:center;margin-top:25px}
.done-btn{background:var(--gradient-1);color:white;padding:12px 30px;border:none;border-radius:25px;font-size:16px;font-weight:600;cursor:pointer;transition:all .3s ease;box-shadow:0 4px 10px rgba(93,59,102,.3)}
.done-btn:hover{transform:translateY(-3px);box-shadow:0 6px 15px rgba(93,59,102,.4)}
.side-cart{position:fixed;top:100px;right:20px;width:320px;z-index:99}
#cartPanel{background:white;border-radius:15px;padding:25px;box-shadow:var(--shadow);transition:all .3s ease}
#cartPanel:hover{box-shadow:var(--shadow-hover)}
#cartPanel h3{font-size:20px;margin-bottom:15px;color:var(--primary-color);font-weight:600;text-align:center;position:relative;padding-bottom:10px}
#cartPanel h3::after{content:'';position:absolute;bottom:0;left:50%;transform:translateX(-50%);width:50px;height:3px;background:var(--gradient-1);border-radius:2px}
#cart-items{max-height:200px;overflow-y:auto;margin-bottom:15px;padding-right:5px}
.cart-item{display:flex;justify-content:space-between;margin-bottom:12px;background:var(--light-gray);padding:10px;border-radius:8px;font-size:14px;transition:all .3s ease}
.cart-item:hover{background:#f0f0f0;transform:translateX(5px)}
.cart-item button{background:transparent;border:none;color:var(--accent-color);font-weight:bold;font-size:16px;cursor:pointer;transition:all .3s ease}
.cart-item button:hover{transform:scale(1.2)}
#cart-total{font-weight:600;font-size:16px;color:var(--primary-color);text-align:right;margin-bottom:15px}
.cart-summary{margin-top:15px;background:var(--light-gray);border-radius:10px;padding:15px;font-size:14px;border:1px solid var(--medium-gray)}
.cart-summary p{margin:8px 0;display:flex;justify-content:space-between}
.cart-summary hr{margin:12px 0;border:none;border-top:1px solid var(--medium-gray)}
.cart-summary strong{font-weight:600;color:var(--primary-color)}
.view-cart-wrapper{text-align:center;margin-top:20px}
.view-cart-btn{background:var(--gradient-2);color:white;padding:12px 25px;font-size:16px;border:none;border-radius:25px;box-shadow:0 4px 15px rgba(0,0,0,.2);cursor:pointer;transition:all .3s ease;font-weight:600}
.view-cart-btn:hover{background:var(--gradient-1);transform:translateY(-3px);box-shadow:0 6px 20px rgba(0,0,0,.25)}
.logo{font-size:1.8rem;font-weight:700;display:flex;align-items:center;color:var(--primary-color)}
.highlight{animation:highlight 2s ease}
@keyframes highlight{0%{background:rgba(93,59,102,.15)}100%{background:transparent}}
.loading{display:inline-block;width:20px;height:20px;border:3px solid rgba(93,59,102,.3);border-radius:50%;border-top-color:var(--primary-color);animation:spin 1s ease-in-out infinite}
@keyframes spin{to{transform:rotate(360deg)}}
@media(max-width:992px){.left-panel{position:relative;top:0;left:0;width:100%;margin-bottom:20px;max-height:none}.main-content{margin-left:0}.side-cart{position:relative;top:0;right:0;width:100%;margin-top:20px}.service-grid{grid-template-columns:repeat(4,1fr)}.banner{flex-direction:column;text-align:center}.banner-text{max-width:100%;margin-bottom:20px}}
@media(max-width:768px){.header{flex-direction:column;padding:15px 20px}.service-grid{grid-template-columns:repeat(2,1fr)}.service-card{flex-direction:column;text-align:center}.service-info{margin-right:0;margin-bottom:15px}}
@media(max-width:576px){.service-grid{grid-template-columns:repeat(2,1fr)}.modal-content{width:95%;padding:20px}}
</style>
</head>
<body>

<header class="header">
  <div class="left-section"><div class="logo">🎨 SpitiCare</div></div>
  <div class="center-section">
    <div class="location-selector" onclick="detectLocation()">
      <span>📍</span><span id="location-name">Use Current Location</span><span class="dropdown-arrow">▼</span>
    </div>
  </div>
  <div class="right-section">
    <nav><ul class="nav-links">
      <li><a href="index.php">Home</a></li>
      <li><a href="services.html">Services</a></li>
    </ul></nav>
  </div>
</header>

<div class="container">
  <div class="left-panel">
    <h3>Select a service</h3>
    <div class="service-grid">
      <div class="service-item" onclick="scrollToSection('interior-painting')">
        <img class="side-icon" src="https://images.unsplash.com/photo-1562259949-e8e7689d7828?w=120&h=120&fit=crop" alt="Interior"/>
        <span>Interior Painting</span>
      </div>
      <div class="service-item" onclick="scrollToSection('exterior-painting')">
        <img class="side-icon" src="https://images.unsplash.com/photo-1589939705384-5185137a7f0f?w=120&h=120&fit=crop" alt="Exterior"/>
        <span>Exterior Painting</span>
      </div>
      <div class="service-item" onclick="scrollToSection('texture-painting')">
        <img class="side-icon" src="https://images.unsplash.com/photo-1604578762246-41134e37f9cc?w=120&h=120&fit=crop" alt="Texture"/>
        <span>Texture & Design</span>
      </div>
      <div class="service-item" onclick="scrollToSection('wood-metal')">
        <img class="side-icon" src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=120&h=120&fit=crop" alt="Wood"/>
        <span>Wood & Metal</span>
      </div>
      <div class="service-item" onclick="scrollToSection('waterproofing')">
        <img class="side-icon" src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=120&h=120&fit=crop" alt="Waterproof"/>
        <span>Waterproofing</span>
      </div>
      <div class="service-item" onclick="scrollToSection('touch-up')">
        <img class="side-icon" src="https://images.unsplash.com/photo-1581578731548-c64695cc6952?w=120&h=120&fit=crop" alt="Touchup"/>
        <span>Touch-up & Repair</span>
      </div>
      <div class="service-item" onclick="scrollToSection('polish-varnish')">
        <img class="side-icon" src="https://images.unsplash.com/photo-1615873968403-89e068629265?w=120&h=120&fit=crop" alt="Polish"/>
        <span>Polish & Varnish</span>
      </div>
      <div class="service-item" onclick="scrollToSection('consultation-painting')">
        <img class="side-icon" src="https://images.unsplash.com/photo-1664575602554-2087b04935a5?w=120&h=120&fit=crop" alt="Consult"/>
        <span>Consultation</span>
      </div>
    </div>
  </div>

  <div class="main-content">
    <div class="right-panel">
      <div class="service-gridd"><h1>Painting Services</h1></div>

      <div class="banner">
        <div class="banner-text">
          <div class="tag">🔥 Super Saver</div>
          <h2>Professional Painting Services</h2>
          <p>Expert painters, premium paints & guaranteed finish. Starting at just ₹99</p>
        </div>
        <img class="banner-img" src="https://images.unsplash.com/photo-1562259949-e8e7689d7828?w=400&h=300&fit=crop" alt="Painting Banner"/>
      </div>

      <!-- INTERIOR PAINTING -->
      <section id="interior-painting" class="service-section">
        <h1>Interior Painting</h1>
        <div class="service-card">
          <div class="service-info"><h2>Full room painting</h2><div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i> 4.84 (22K reviews)</div><div class="price">Starts at ₹999</div><div class="desc">Complete wall & ceiling painting for one room with premium finish</div><a href="#" class="view-link">View details</a></div>
          <div class="service-image"><img src="https://images.unsplash.com/photo-1562259949-e8e7689d7828?w=200&h=200&fit=crop" alt="Full room"/><button class="add-button" onclick="openModal('m_int1')">Add</button><div class="options">3 options</div></div>
        </div>
        <div class="service-card">
          <div class="service-info"><h2>Single wall painting</h2><div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i> 4.81 (10K reviews)</div><div class="price">Starts at ₹299</div><a href="#" class="view-link">View details</a></div>
          <div class="service-image"><img src="https://images.unsplash.com/photo-1589939705384-5185137a7f0f?w=200&h=200&fit=crop" alt="Single wall"/><button class="add-button" onclick="openModal('m_int2')">Add</button><div class="options">2 options</div></div>
        </div>
        <div class="service-card">
          <div class="service-info"><h2>Ceiling painting</h2><div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i> 4.80 (8K reviews)</div><div class="price">Starts at ₹499</div><a href="#" class="view-link">View details</a></div>
          <div class="service-image"><img src="https://images.unsplash.com/photo-1513694203232-719a280e022f?w=200&h=200&fit=crop" alt="Ceiling"/><button class="add-button" onclick="openModal('m_int3')">Add</button></div>
        </div>
        <div class="service-card">
          <div class="service-info"><h2>Full home interior painting</h2><div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i> 4.86 (30K reviews)</div><div class="price">Starts at ₹4,999</div><div class="desc">Complete interior painting for entire home (BHK-wise pricing)</div><a href="#" class="view-link">View details</a></div>
          <div class="service-image"><img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=200&h=200&fit=crop" alt="Full home"/><button class="add-button" onclick="openModal('m_int4')">Add</button><div class="options">4 options</div></div>
        </div>
      </section>

      <div id="m_int1" class="modal"><div class="modal-content"><span class="close-btn" onclick="closeModal('m_int1')">×</span><img class="modal-hero" src="https://images.unsplash.com/photo-1562259949-e8e7689d7828?w=600&h=200&fit=crop" alt=""/><h2>Full room painting</h2><p>★ 4.84 (22K reviews)</p><div class="process-section"><h2>Our process</h2><div class="process-step"><strong>Site assessment</strong>We assess wall condition, area size & share a detailed quote</div><div class="process-step"><strong>Surface preparation</strong>Walls cleaned, sanded & primed for best finish</div><div class="process-step"><strong>Painting</strong>2-coat application of premium quality paint</div><div class="process-step"><strong>Quality check & cleanup</strong>Final inspection & complete site cleanup before handover</div></div><div class="modal-footer"><button class="done-btn" onclick="addToCart('Full room painting',999,'m_int1')">Done</button></div></div></div>
      <div id="m_int2" class="modal"><div class="modal-content"><span class="close-btn" onclick="closeModal('m_int2')">×</span><img class="modal-hero" src="https://images.unsplash.com/photo-1589939705384-5185137a7f0f?w=600&h=200&fit=crop" alt=""/><h2>Single wall painting</h2><p>★ 4.81 (10K reviews)</p><div class="process-section"><h2>Our process</h2><div class="process-step"><strong>Site assessment</strong>We assess wall condition & share a quote</div><div class="process-step"><strong>Surface preparation</strong>Wall cleaned, sanded & primed</div><div class="process-step"><strong>Painting</strong>2-coat premium paint application</div><div class="process-step"><strong>Quality check & cleanup</strong>Inspection & cleanup</div></div><div class="modal-footer"><button class="done-btn" onclick="addToCart('Single wall painting',299,'m_int2')">Done</button></div></div></div>
      <div id="m_int3" class="modal"><div class="modal-content"><span class="close-btn" onclick="closeModal('m_int3')">×</span><img class="modal-hero" src="https://images.unsplash.com/photo-1513694203232-719a280e022f?w=600&h=200&fit=crop" alt=""/><h2>Ceiling painting</h2><p>★ 4.80 (8K reviews)</p><div class="process-section"><h2>Our process</h2><div class="process-step"><strong>Site assessment</strong>We assess ceiling condition & share a quote</div><div class="process-step"><strong>Surface preparation</strong>Ceiling cleaned, patched & primed</div><div class="process-step"><strong>Painting</strong>2-coat ceiling paint application</div><div class="process-step"><strong>Quality check & cleanup</strong>Inspection & full cleanup</div></div><div class="modal-footer"><button class="done-btn" onclick="addToCart('Ceiling painting',499,'m_int3')">Done</button></div></div></div>
      <div id="m_int4" class="modal"><div class="modal-content"><span class="close-btn" onclick="closeModal('m_int4')">×</span><img class="modal-hero" src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600&h=200&fit=crop" alt=""/><h2>Full home interior painting</h2><p>★ 4.86 (30K reviews)</p><div class="process-section"><h2>Our process</h2><div class="process-step"><strong>Site assessment</strong>Entire home measured & quote prepared</div><div class="process-step"><strong>Surface preparation</strong>All walls cleaned, sanded & primed</div><div class="process-step"><strong>Painting</strong>Premium 2-coat application throughout home</div><div class="process-step"><strong>Quality check & cleanup</strong>Room-by-room inspection & full cleanup</div></div><div class="modal-footer"><button class="done-btn" onclick="addToCart('Full home interior painting',4999,'m_int4')">Done</button></div></div></div>

      <!-- EXTERIOR PAINTING -->
      <section id="exterior-painting" class="service-section">
        <h1>Exterior Painting</h1>
        <div class="service-card">
          <div class="service-info"><h2>Exterior wall painting</h2><div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i> 4.82 (18K reviews)</div><div class="price">Starts at ₹1,499</div><div class="desc">Weather-resistant exterior wall painting</div><a href="#" class="view-link">View details</a></div>
          <div class="service-image"><img src="https://images.unsplash.com/photo-1570129477492-45c003edd2be?w=200&h=200&fit=crop" alt="Exterior"/><button class="add-button" onclick="openModal('m_ext1')">Add</button><div class="options">3 options</div></div>
        </div>
        <div class="service-card">
          <div class="service-info"><h2>Boundary wall painting</h2><div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i> 4.79 (6K reviews)</div><div class="price">Starts at ₹799</div><a href="#" class="view-link">View details</a></div>
          <div class="service-image"><img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=200&h=200&fit=crop" alt="Boundary"/><button class="add-button" onclick="openModal('m_ext2')">Add</button></div>
        </div>
        <div class="service-card">
          <div class="service-info"><h2>Full building exterior painting</h2><div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i> 4.85 (12K reviews)</div><div class="price">Starts at ₹9,999</div><div class="desc">Complete exterior painting with scaffolding setup</div><a href="#" class="view-link">View details</a></div>
          <div class="service-image"><img src="https://images.unsplash.com/photo-1486325212027-8081e485255e?w=200&h=200&fit=crop" alt="Building"/><button class="add-button" onclick="openModal('m_ext3')">Add</button><div class="options">2 options</div></div>
        </div>
      </section>

      <div id="m_ext1" class="modal"><div class="modal-content"><span class="close-btn" onclick="closeModal('m_ext1')">×</span><img class="modal-hero" src="https://images.unsplash.com/photo-1570129477492-45c003edd2be?w=600&h=200&fit=crop" alt=""/><h2>Exterior wall painting</h2><p>★ 4.82 (18K reviews)</p><div class="process-section"><h2>Our process</h2><div class="process-step"><strong>Site assessment</strong>Inspect exterior walls, measure area & share quote</div><div class="process-step"><strong>Surface preparation</strong>Cleaning, crack filling & weather-proof primer</div><div class="process-step"><strong>Painting</strong>2-coat weather-resistant exterior paint</div><div class="process-step"><strong>Quality check & cleanup</strong>Inspection & cleanup</div></div><div class="modal-footer"><button class="done-btn" onclick="addToCart('Exterior wall painting',1499,'m_ext1')">Done</button></div></div></div>
      <div id="m_ext2" class="modal"><div class="modal-content"><span class="close-btn" onclick="closeModal('m_ext2')">×</span><img class="modal-hero" src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=600&h=200&fit=crop" alt=""/><h2>Boundary wall painting</h2><p>★ 4.79 (6K reviews)</p><div class="process-section"><h2>Our process</h2><div class="process-step"><strong>Site assessment</strong>Inspect boundary wall & share quote</div><div class="process-step"><strong>Surface preparation</strong>Cleaning, patching & primer</div><div class="process-step"><strong>Painting</strong>Premium exterior paint coat</div><div class="process-step"><strong>Quality check & cleanup</strong>Inspection & cleanup</div></div><div class="modal-footer"><button class="done-btn" onclick="addToCart('Boundary wall painting',799,'m_ext2')">Done</button></div></div></div>
      <div id="m_ext3" class="modal"><div class="modal-content"><span class="close-btn" onclick="closeModal('m_ext3')">×</span><img class="modal-hero" src="https://images.unsplash.com/photo-1486325212027-8081e485255e?w=600&h=200&fit=crop" alt=""/><h2>Full building exterior painting</h2><p>★ 4.85 (12K reviews)</p><div class="process-section"><h2>Our process</h2><div class="process-step"><strong>Site assessment</strong>Complete building survey & detailed quote</div><div class="process-step"><strong>Scaffolding & preparation</strong>Safe scaffold setup, surface cleaning & priming</div><div class="process-step"><strong>Painting</strong>Multi-coat weather-resistant paint</div><div class="process-step"><strong>Quality check & cleanup</strong>Inspection, scaffold removal & site cleanup</div></div><div class="modal-footer"><button class="done-btn" onclick="addToCart('Full building exterior painting',9999,'m_ext3')">Done</button></div></div></div>

      <!-- TEXTURE & DESIGN -->
      <section id="texture-painting" class="service-section">
        <h1>Texture & Design Painting</h1>
        <div class="service-card">
          <div class="service-info"><h2>Texture paint (per wall)</h2><div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i> 4.83 (14K reviews)</div><div class="price">Starts at ₹599</div><div class="desc">Sand, stone, bark or smooth texture finishes</div><a href="#" class="view-link">View details</a></div>
          <div class="service-image"><img src="https://images.unsplash.com/photo-1604578762246-41134e37f9cc?w=200&h=200&fit=crop" alt="Texture"/><button class="add-button" onclick="openModal('m_tex1')">Add</button><div class="options">4 options</div></div>
        </div>
        <div class="service-card">
          <div class="service-info"><h2>Designer / feature wall</h2><div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i> 4.84 (9K reviews)</div><div class="price">Starts at ₹799</div><a href="#" class="view-link">View details</a></div>
          <div class="service-image"><img src="https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?w=200&h=200&fit=crop" alt="Designer"/><button class="add-button" onclick="openModal('m_tex2')">Add</button><div class="options">3 options</div></div>
        </div>
                         <div class="service-card">
          <div class="service-info"><h2>Stencil / pattern painting</h2><div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i> 4.81 (7K reviews)</div><div class="price">Starts at ₹499</div><a href="#" class="view-link">View details</a></div>
          <div class="service-image"><img src="https://images.unsplash.com/photo-1534349762230-e0cadf78f5da?w=200&h=200&fit=crop" alt="Stencil"/><button class="add-button" onclick="openModal('m_tex4')">Add</button><div class="options">2 options</div></div>
        </div>
      </section>

      <div id="m_tex1" class="modal"><div class="modal-content"><span class="close-btn" onclick="closeModal('m_tex1')">×</span><img class="modal-hero" src="https://images.unsplash.com/photo-1604578762246-41134e37f9cc?w=600&h=200&fit=crop" alt=""/><h2>Texture paint (per wall)</h2><p>★ 4.83 (14K reviews)</p><div class="process-section"><h2>Our process</h2><div class="process-step"><strong>Design consultation</strong>We help you choose the right texture & color</div><div class="process-step"><strong>Surface preparation</strong>Wall cleaned, sanded & base coat applied</div><div class="process-step"><strong>Texture application</strong>Expert texture in your chosen finish</div><div class="process-step"><strong>Quality check & cleanup</strong>Inspection & cleanup</div></div><div class="modal-footer"><button class="done-btn" onclick="addToCart('Texture paint (per wall)',599,'m_tex1')">Done</button></div></div></div>
      <div id="m_tex2" class="modal"><div class="modal-content"><span class="close-btn" onclick="closeModal('m_tex2')">×</span><img class="modal-hero" src="https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?w=600&h=200&fit=crop" alt=""/><h2>Designer / feature wall</h2><p>★ 4.84 (9K reviews)</p><div class="process-section"><h2>Our process</h2><div class="process-step"><strong>Design consultation</strong>Discuss design concepts, colors & theme</div><div class="process-step"><strong>Surface preparation</strong>Wall prepped with base coat</div><div class="process-step"><strong>Artistic painting</strong>Custom designer finish by skilled artist</div><div class="process-step"><strong>Quality check & cleanup</strong>Review & full site cleanup</div></div><div class="modal-footer"><button class="done-btn" onclick="addToCart('Designer / feature wall',799,'m_tex2')">Done</button></div></div></div>
      <div id="m_tex3" class="modal"><div class="modal-content"><span class="close-btn" onclick="closeModal('m_tex3')">×</span><img class="modal-hero" src="https://images.unsplash.com/photo-1579541591970-e5e43dc0a8e2?w=600&h=200&fit=crop" alt=""/><h2>3D wall painting</h2><p>★ 4.86 (5K reviews)</p><div class="process-section"><h2>Our process</h2><div class="process-step"><strong>Design consultation</strong>Select from our 3D design catalogue</div><div class="process-step"><strong>Surface preparation</strong>Wall primed & base coated</div><div class="process-step"><strong>3D painting</strong>Expert 3D art application</div><div class="process-step"><strong>Quality check & cleanup</strong>Inspection & cleanup</div></div><div class="modal-footer"><button class="done-btn" onclick="addToCart('3D wall painting',1299,'m_tex3')">Done</button></div></div></div>
      <div id="m_tex4" class="modal"><div class="modal-content"><span class="close-btn" onclick="closeModal('m_tex4')">×</span><img class="modal-hero" src="https://images.unsplash.com/photo-1534349762230-e0cadf78f5da?w=600&h=200&fit=crop" alt=""/><h2>Stencil / pattern painting</h2><p>★ 4.81 (7K reviews)</p><div class="process-section"><h2>Our process</h2><div class="process-step"><strong>Design selection</strong>Choose from our stencil library</div><div class="process-step"><strong>Surface preparation</strong>Base coat on clean wall</div><div class="process-step"><strong>Stencil painting</strong>Precise stencil in your color choice</div><div class="process-step"><strong>Quality check & cleanup</strong>Inspection & cleanup</div></div><div class="modal-footer"><button class="done-btn" onclick="addToCart('Stencil / pattern painting',499,'m_tex4')">Done</button></div></div></div>

      <!-- WOOD & METAL -->
      <section id="wood-metal" class="service-section">
        <h1>Wood & Metal Painting</h1>
        <div class="service-card">
          <div class="service-info"><h2>Door painting / staining</h2><div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i> 4.82 (11K reviews)</div><div class="price">Starts at ₹199</div><a href="#" class="view-link">View details</a></div>
          <div class="service-image"><img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=200&h=200&fit=crop" alt="Door"/><button class="add-button" onclick="openModal('m_wm1')">Add</button><div class="options">3 options</div></div>
        </div>
        <div class="service-card">
          <div class="service-info"><h2>Window frame painting</h2><div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i> 4.80 (7K reviews)</div><div class="price">Starts at ₹149</div><a href="#" class="view-link">View details</a></div>
          <div class="service-image"><img src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=200&h=200&fit=crop" alt="Window"/><button class="add-button" onclick="openModal('m_wm2')">Add</button><div class="options">2 options</div></div>
        </div>
        <div class="service-card">
          <div class="service-info"><h2>Metal grill / gate painting</h2><div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i> 4.79 (5K reviews)</div><div class="price">Starts at ₹299</div><a href="#" class="view-link">View details</a></div>
          <div class="service-image"><img src="https://images.unsplash.com/photo-1587293852726-70cdb56c2866?w=200&h=200&fit=crop" alt="Metal"/><button class="add-button" onclick="openModal('m_wm3')">Add</button></div>
        </div>
        <div class="service-card">
          <div class="service-info"><h2>Furniture painting / polishing</h2><div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i> 4.83 (9K reviews)</div><div class="price">Starts at ₹249</div><a href="#" class="view-link">View details</a></div>
          <div class="service-image"><img src="https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=200&h=200&fit=crop" alt="Furniture"/><button class="add-button" onclick="openModal('m_wm4')">Add</button><div class="options">3 options</div></div>
        </div>
      </section>

      <div id="m_wm1" class="modal"><div class="modal-content"><span class="close-btn" onclick="closeModal('m_wm1')">×</span><img class="modal-hero" src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600&h=200&fit=crop" alt=""/><h2>Door painting / staining</h2><p>★ 4.82 (11K reviews)</p><div class="process-section"><h2>Our process</h2><div class="process-step"><strong>Inspection</strong>We inspect door condition & share a quote</div><div class="process-step"><strong>Surface preparation</strong>Sanding, puttying & primer</div><div class="process-step"><strong>Painting / Staining</strong>2-coat premium wood paint or stain</div><div class="process-step"><strong>Quality check & cleanup</strong>Inspection & cleanup</div></div><div class="modal-footer"><button class="done-btn" onclick="addToCart('Door painting / staining',199,'m_wm1')">Done</button></div></div></div>
      <div id="m_wm2" class="modal"><div class="modal-content"><span class="close-btn" onclick="closeModal('m_wm2')">×</span><img class="modal-hero" src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=600&h=200&fit=crop" alt=""/><h2>Window frame painting</h2><p>★ 4.80 (7K reviews)</p><div class="process-section"><h2>Our process</h2><div class="process-step"><strong>Inspection</strong>We inspect frames & share a quote</div><div class="process-step"><strong>Surface preparation</strong>Sanding & primer</div><div class="process-step"><strong>Painting</strong>Precision painting of window frames</div><div class="process-step"><strong>Quality check & cleanup</strong>Inspection & cleanup</div></div><div class="modal-footer"><button class="done-btn" onclick="addToCart('Window frame painting',149,'m_wm2')">Done</button></div></div></div>
      <div id="m_wm3" class="modal"><div class="modal-content"><span class="close-btn" onclick="closeModal('m_wm3')">×</span><img class="modal-hero" src="https://images.unsplash.com/photo-1587293852726-70cdb56c2866?w=600&h=200&fit=crop" alt=""/><h2>Metal grill / gate painting</h2><p>★ 4.79 (5K reviews)</p><div class="process-section"><h2>Our process</h2><div class="process-step"><strong>Inspection</strong>We inspect metal surfaces & share a quote</div><div class="process-step"><strong>Surface preparation</strong>Rust removal, cleaning & anti-rust primer</div><div class="process-step"><strong>Painting</strong>Rust-resistant enamel paint</div><div class="process-step"><strong>Quality check & cleanup</strong>Inspection & cleanup</div></div><div class="modal-footer"><button class="done-btn" onclick="addToCart('Metal grill / gate painting',299,'m_wm3')">Done</button></div></div></div>
      <div id="m_wm4" class="modal"><div class="modal-content"><span class="close-btn" onclick="closeModal('m_wm4')">×</span><img class="modal-hero" src="https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=600&h=200&fit=crop" alt=""/><h2>Furniture painting / polishing</h2><p>★ 4.83 (9K reviews)</p><div class="process-section"><h2>Our process</h2><div class="process-step"><strong>Inspection</strong>We assess furniture condition & share a quote</div><div class="process-step"><strong>Surface preparation</strong>Sanding, cleaning & base coat</div><div class="process-step"><strong>Painting / Polishing</strong>Premium paint or polish applied</div><div class="process-step"><strong>Quality check & cleanup</strong>Inspection & cleanup</div></div><div class="modal-footer"><button class="done-btn" onclick="addToCart('Furniture painting / polishing',249,'m_wm4')">Done</button></div></div></div>

      <!-- WATERPROOFING -->
      <section id="waterproofing" class="service-section">
        <h1>Waterproofing</h1>
        <div class="service-card">
          <div class="service-info"><h2>Terrace / roof waterproofing</h2><div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i> 4.85 (16K reviews)</div><div class="price">Starts at ₹1,999</div><div class="desc">Long-lasting waterproof coating for terraces & flat roofs</div><a href="#" class="view-link">View details</a></div>
          <div class="service-image"><img src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=200&h=200&fit=crop" alt="Terrace"/><button class="add-button" onclick="openModal('m_wp1')">Add</button><div class="options">2 options</div></div>
        </div>
        <div class="service-card">
          <div class="service-info"><h2>Bathroom waterproofing</h2><div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i> 4.83 (12K reviews)</div><div class="price">Starts at ₹999</div><a href="#" class="view-link">View details</a></div>
          <div class="service-image"><img src="https://images.unsplash.com/photo-1552321554-5fefe8c9ef14?w=200&h=200&fit=crop" alt="Bathroom"/><button class="add-button" onclick="openModal('m_wp2')">Add</button></div>
        </div>
        <div class="service-card">
          <div class="service-info"><h2>Basement waterproofing</h2><div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i> 4.80 (8K reviews)</div><div class="price">Starts at ₹2,499</div><a href="#" class="view-link">View details</a></div>
          <div class="service-image"><img src="https://images.unsplash.com/photo-1565538810643-b5bdb714032a?w=200&h=200&fit=crop" alt="Basement"/><button class="add-button" onclick="openModal('m_wp3')">Add</button><div class="options">2 options</div></div>
        </div>
      </section>

      <div id="m_wp1" class="modal"><div class="modal-content"><span class="close-btn" onclick="closeModal('m_wp1')">×</span><img class="modal-hero" src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=600&h=200&fit=crop" alt=""/><h2>Terrace / roof waterproofing</h2><p>★ 4.85 (16K reviews)</p><div class="process-section"><h2>Our process</h2><div class="process-step"><strong>Inspection</strong>Inspect terrace, identify leak points & share quote</div><div class="process-step"><strong>Surface preparation</strong>Cracks filled, surface cleaned & dried</div><div class="process-step"><strong>Waterproof coating</strong>Multi-layer waterproof membrane applied</div><div class="process-step"><strong>Quality check & cleanup</strong>Water test & full cleanup</div></div><div class="modal-footer"><button class="done-btn" onclick="addToCart('Terrace / roof waterproofing',1999,'m_wp1')">Done</button></div></div></div>
      <div id="m_wp2" class="modal"><div class="modal-content"><span class="close-btn" onclick="closeModal('m_wp2')">×</span><img class="modal-hero" src="https://images.unsplash.com/photo-1552321554-5fefe8c9ef14?w=600&h=200&fit=crop" alt=""/><h2>Bathroom waterproofing</h2><p>★ 4.83 (12K reviews)</p><div class="process-section"><h2>Our process</h2><div class="process-step"><strong>Inspection</strong>Inspect bathroom walls/floor & share quote</div><div class="process-step"><strong>Surface preparation</strong>Surface cleaned, joints sealed</div><div class="process-step"><strong>Waterproof coating</strong>Waterproof compound applied</div><div class="process-step"><strong>Quality check & cleanup</strong>Inspection & cleanup</div></div><div class="modal-footer"><button class="done-btn" onclick="addToCart('Bathroom waterproofing',999,'m_wp2')">Done</button></div></div></div>
      <div id="m_wp3" class="modal"><div class="modal-content"><span class="close-btn" onclick="closeModal('m_wp3')">×</span><img class="modal-hero" src="https://images.unsplash.com/photo-1565538810643-b5bdb714032a?w=600&h=200&fit=crop" alt=""/><h2>Basement waterproofing</h2><p>★ 4.80 (8K reviews)</p><div class="process-section"><h2>Our process</h2><div class="process-step"><strong>Inspection</strong>Full basement assessment & quote</div><div class="process-step"><strong>Surface preparation</strong>Cracks filled, surface cleaned</div><div class="process-step"><strong>Waterproof coating</strong>Heavy-duty waterproofing applied</div><div class="process-step"><strong>Quality check & cleanup</strong>Water test & cleanup</div></div><div class="modal-footer"><button class="done-btn" onclick="addToCart('Basement waterproofing',2499,'m_wp3')">Done</button></div></div></div>

      <!-- TOUCH-UP & REPAIR -->
      <section id="touch-up" class="service-section">
        <h1>Touch-up & Repair</h1>
        <div class="service-card">
          <div class="service-info"><h2>Wall crack filling & touch-up</h2><div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i> 4.81 (20K reviews)</div><div class="price">Starts at ₹199</div><a href="#" class="view-link">View details</a></div>
          <div class="service-image"><img src="https://images.unsplash.com/photo-1581578731548-c64695cc6952?w=200&h=200&fit=crop" alt="Crack"/><button class="add-button" onclick="openModal('m_tu1')">Add</button><div class="options">2 options</div></div>
        </div>
        <div class="service-card">
          <div class="service-info"><h2>Peeling paint repair</h2><div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i> 4.80 (9K reviews)</div><div class="price">Starts at ₹299</div><a href="#" class="view-link">View details</a></div>
          <div class="service-image"><img src="https://images.unsplash.com/photo-1572981779307-38b8cabb2407?w=200&h=200&fit=crop" alt="Peeling"/><button class="add-button" onclick="openModal('m_tu2')">Add</button></div>
        </div>
        <div class="service-card">
          <div class="service-info"><h2>Seepage & stain treatment</h2><div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i> 4.82 (7K reviews)</div><div class="price">Starts at ₹399</div><a href="#" class="view-link">View details</a></div>
          <div class="service-image"><img src="https://images.unsplash.com/photo-1584622650111-993a426fbf0a?w=200&h=200&fit=crop" alt="Seepage"/><button class="add-button" onclick="openModal('m_tu3')">Add</button><div class="options">2 options</div></div>
        </div>
      </section>

      <div id="m_tu1" class="modal"><div class="modal-content"><span class="close-btn" onclick="closeModal('m_tu1')">×</span><img class="modal-hero" src="https://images.unsplash.com/photo-1581578731548-c64695cc6952?w=600&h=200&fit=crop" alt=""/><h2>Wall crack filling & touch-up</h2><p>★ 4.81 (20K reviews)</p><div class="process-section"><h2>Our process</h2><div class="process-step"><strong>Inspection</strong>We assess cracks & damage, share a quote</div><div class="process-step"><strong>Crack filling</strong>Cracks filled with premium putty/compound</div><div class="process-step"><strong>Touch-up painting</strong>Color-matched paint for seamless finish</div><div class="process-step"><strong>Quality check & cleanup</strong>Inspection & cleanup</div></div><div class="modal-footer"><button class="done-btn" onclick="addToCart('Wall crack filling & touch-up',199,'m_tu1')">Done</button></div></div></div>
      <div id="m_tu2" class="modal"><div class="modal-content"><span class="close-btn" onclick="closeModal('m_tu2')">×</span><img class="modal-hero" src="https://images.unsplash.com/photo-1572981779307-38b8cabb2407?w=600&h=200&fit=crop" alt=""/><h2>Peeling paint repair</h2><p>★ 4.80 (9K reviews)</p><div class="process-section"><h2>Our process</h2><div class="process-step"><strong>Inspection</strong>Assess peeling extent & share quote</div><div class="process-step"><strong>Old paint removal</strong>Loose/peeling paint stripped</div><div class="process-step"><strong>Re-painting</strong>Fresh primer & paint applied</div><div class="process-step"><strong>Quality check & cleanup</strong>Inspection & cleanup</div></div><div class="modal-footer"><button class="done-btn" onclick="addToCart('Peeling paint repair',299,'m_tu2')">Done</button></div></div></div>
      <div id="m_tu3" class="modal"><div class="modal-content"><span class="close-btn" onclick="closeModal('m_tu3')">×</span><img class="modal-hero" src="https://images.unsplash.com/photo-1584622650111-993a426fbf0a?w=600&h=200&fit=crop" alt=""/><h2>Seepage & stain treatment</h2><p>★ 4.82 (7K reviews)</p><div class="process-section"><h2>Our process</h2><div class="process-step"><strong>Inspection</strong>Identify seepage source & share quote</div><div class="process-step"><strong>Treatment</strong>Anti-seepage chemical treatment applied</div><div class="process-step"><strong>Repainting</strong>Affected area repainted</div><div class="process-step"><strong>Quality check & cleanup</strong>Inspection & cleanup</div></div><div class="modal-footer"><button class="done-btn" onclick="addToCart('Seepage & stain treatment',399,'m_tu3')">Done</button></div></div></div>

      <!-- POLISH & VARNISH -->
      <section id="polish-varnish" class="service-section">
        <h1>Polish & Varnish</h1>
        <div class="service-card">
          <div class="service-info"><h2>Wood floor polishing</h2><div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i> 4.83 (10K reviews)</div><div class="price">Starts at ₹799</div><a href="#" class="view-link">View details</a></div>
          <div class="service-image"><img src="https://images.unsplash.com/photo-1615873968403-89e068629265?w=200&h=200&fit=crop" alt="Floor"/><button class="add-button" onclick="openModal('m_pv1')">Add</button><div class="options">2 options</div></div>
        </div>
        <div class="service-card">
          <div class="service-info"><h2>Wood varnishing (per door/window)</h2><div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i> 4.80 (8K reviews)</div><div class="price">Starts at ₹249</div><a href="#" class="view-link">View details</a></div>
          <div class="service-image"><img src="https://images.unsplash.com/photo-1600585152220-90363fe7e115?w=200&h=200&fit=crop" alt="Varnish"/><button class="add-button" onclick="openModal('m_pv2')">Add</button></div>
        </div>
        <div class="service-card">
          <div class="service-info"><h2>Marble / tile polishing</h2><div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i> 4.84 (12K reviews)</div><div class="price">Starts at ₹999</div><div class="desc">Machine polishing for marble & granite surfaces</div><a href="#" class="view-link">View details</a></div>
          <div class="service-image"><img src="https://images.unsplash.com/photo-1600566752355-35792bedcfea?w=200&h=200&fit=crop" alt="Marble"/><button class="add-button" onclick="openModal('m_pv3')">Add</button><div class="options">3 options</div></div>
        </div>
      </section>

      <div id="m_pv1" class="modal"><div class="modal-content"><span class="close-btn" onclick="closeModal('m_pv1')">×</span><img class="modal-hero" src="https://images.unsplash.com/photo-1615873968403-89e068629265?w=600&h=200&fit=crop" alt=""/><h2>Wood floor polishing</h2><p>★ 4.83 (10K reviews)</p><div class="process-section"><h2>Our process</h2><div class="process-step"><strong>Inspection</strong>Assess floor condition & share quote</div><div class="process-step"><strong>Surface preparation</strong>Floor sanded & cleaned</div><div class="process-step"><strong>Polishing</strong>Machine polish for high-gloss finish</div><div class="process-step"><strong>Quality check & cleanup</strong>Inspection & cleanup</div></div><div class="modal-footer"><button class="done-btn" onclick="addToCart('Wood floor polishing',799,'m_pv1')">Done</button></div></div></div>
      <div id="m_pv2" class="modal"><div class="modal-content"><span class="close-btn" onclick="closeModal('m_pv2')">×</span><img class="modal-hero" src="https://images.unsplash.com/photo-1600585152220-90363fe7e115?w=600&h=200&fit=crop" alt=""/><h2>Wood varnishing</h2><p>★ 4.80 (8K reviews)</p><div class="process-section"><h2>Our process</h2><div class="process-step"><strong>Inspection</strong>Assess wood condition & share quote</div><div class="process-step"><strong>Surface preparation</strong>Sanding & cleaning</div><div class="process-step"><strong>Varnishing</strong>2-coat varnish applied</div><div class="process-step"><strong>Quality check & cleanup</strong>Inspection & cleanup</div></div><div class="modal-footer"><button class="done-btn" onclick="addToCart('Wood varnishing',249,'m_pv2')">Done</button></div></div></div>
      <div id="m_pv3" class="modal"><div class="modal-content"><span class="close-btn" onclick="closeModal('m_pv3')">×</span><img class="modal-hero" src="https://images.unsplash.com/photo-1600566752355-35792bedcfea?w=600&h=200&fit=crop" alt=""/><h2>Marble / tile polishing</h2><p>★ 4.84 (12K reviews)</p><div class="process-section"><h2>Our process</h2><div class="process-step"><strong>Inspection</strong>Assess surface condition & share quote</div><div class="process-step"><strong>Deep cleaning</strong>Thorough cleaning of marble/tile surface</div><div class="process-step"><strong>Machine polishing</strong>Diamond polishing for mirror finish</div><div class="process-step"><strong>Quality check & cleanup</strong>Inspection & cleanup</div></div><div class="modal-footer"><button class="done-btn" onclick="addToCart('Marble / tile polishing',999,'m_pv3')">Done</button></div></div></div>

      <!-- CONSULTATION -->
      <section id="consultation-painting" class="service-section">
        <h1>Book a Consultation</h1>
        <div class="service-card">
          <div class="service-info"><h2>Painting consultation</h2><div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i> 4.82 (5K reviews)</div><div class="price">Starts at ₹49</div><div class="desc">Expert advice on paint types, colors & detailed estimate</div><a href="#" class="view-link">View details</a></div>
          <div class="service-image"><img src="https://images.unsplash.com/photo-1664575602554-2087b04935a5?w=200&h=200&fit=crop" alt="Consult"/><button class="add-button" onclick="openModal('m_con1')">Add</button></div>
        </div>
      </section>

      <div id="m_con1" class="modal"><div class="modal-content"><span class="close-btn" onclick="closeModal('m_con1')">×</span><img class="modal-hero" src="https://images.unsplash.com/photo-1664575602554-2087b04935a5?w=600&h=200&fit=crop" alt=""/><h2>Painting consultation</h2><p>★ 4.82 (5K reviews)</p><div class="process-section"><h2>Our process</h2><div class="process-step"><strong>Site visit</strong>Our expert visits your location</div><div class="process-step"><strong>Assessment</strong>Area, wall condition & requirements assessed</div><div class="process-step"><strong>Recommendations</strong>Color, paint type & finish recommendations</div><div class="process-step"><strong>Detailed estimate</strong>Comprehensive cost estimate provided</div></div><div class="modal-footer"><button class="done-btn" onclick="addToCart('Painting consultation',49,'m_con1')">Done</button></div></div></div>

    </div>
  </div>

  <!-- Cart -->
  <div class="side-cart">
    <div id="cartPanel">
      <h3>🛒 Your Cart</h3>
      <div id="cart-items"></div>
      <div><strong>Total:</strong> <span id="cart-total">₹0</span></div>
      <div class="cart-summary" id="cartSummary" style="margin-top:10px;display:none">
        <hr>
        <p><strong>Item Total:</strong> ₹<span id="item-total">0</span></p>
        <p><strong>Taxes (18%):</strong> ₹<span id="tax">0</span></p>
        <p><strong>Platform Charges:</strong> ₹69</p>
        <hr>
        <p><strong>Total Amount:</strong> ₹<span id="total-amount">0</span></p>
      </div>
      <div class="view-cart-wrapper">
        <button onclick="alert('Proceeding to cart!')" class="view-cart-btn">🛒 View Cart</button>
      </div>
    </div>
  </div>
</div>

<script>
function openModal(id){document.getElementById(id).style.display='block'}
function closeModal(id){document.getElementById(id).style.display='none'}
window.onclick=function(e){document.querySelectorAll('.modal').forEach(m=>{if(e.target==m)m.style.display='none'})}
function scrollToSection(id){const s=document.getElementById(id);if(s){s.scrollIntoView({behavior:'smooth',block:'start'});s.classList.add('highlight');setTimeout(()=>s.classList.remove('highlight'),2000)}}
function detectLocation(){
  const s=document.getElementById("location-name");s.innerHTML='<div class="loading"></div>';
  if("geolocation" in navigator){navigator.geolocation.getCurrentPosition(async p=>{try{const r=await fetch(`https://nominatim.openstreetmap.org/reverse?lat=${p.coords.latitude}&lon=${p.coords.longitude}&format=json`,{headers:{'User-Agent':'SpitiCare/1.0'}});const d=await r.json();const{city,town,village,state}=d.address;s.textContent=city||town||village||state||"Location found";}catch{s.textContent="Location found"}},()=>{s.textContent="Nagpur, Maharashtra"});}else s.textContent="Location not supported";
}
let cart=[];
function addToCart(name,price,modalId){
  const ex=cart.find(i=>i.name===name);
  if(ex)ex.qty+=1;else cart.push({name,price,qty:1});
  updateCartUI();closeModal(modalId);
}
function updateCartUI(){
  const ci=document.getElementById('cart-items');ci.innerHTML="";let total=0;
  cart.forEach(item=>{const sub=item.price*item.qty;total+=sub;const d=document.createElement('div');d.className='cart-item';d.innerHTML=`<span>${item.name}<br><small>₹${item.price} × ${item.qty} = ₹${sub}</small></span><button onclick="removeFromCart('${item.name.replace(/'/g,"\\'")}')">×</button>`;ci.appendChild(d);});
  document.getElementById('cart-total').textContent=`₹${total}`;
  document.getElementById('item-total').textContent=total;
  const tax=(total*0.18).toFixed(2);
  document.getElementById('tax').textContent=tax;
  document.getElementById('total-amount').textContent=(total+parseFloat(tax)+69).toFixed(2);
  document.getElementById('cartSummary').style.display=cart.length?'block':'none';
}
function removeFromCart(name){cart=cart.filter(i=>i.name!==name);updateCartUI();}
window.addEventListener('scroll',()=>{document.querySelector('.header').classList.toggle('scrolled',window.scrollY>50)});
</script>
</body>
</html>