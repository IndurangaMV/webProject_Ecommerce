<header class="site-header" style="padding:14px 0;background:#CCCCCC;border:1px solid #b8b8b8;border-radius:26px;box-shadow:0 8px 22px rgba(15, 23, 42, 0.10);width:calc(100% - 8px);margin:8px auto 0;overflow:hidden;">
  <div class="container" style="display:flex;align-items:center;justify-content:space-between;width:100%;margin:0 auto;padding:0 20px;gap:16px;box-sizing:border-box;">
    <a href="#" class="brand" style="display:inline-flex;align-items:center;gap:12px;text-decoration:none;">
      <img src="../assests/images/login/logo.png" alt="Company Logo" style="max-height:64px;display:block;" />
      <div style="display:flex;flex-direction:column;justify-content:center;line-height:1;">
        <span style="display:inline-block;font-size:1.35rem;font-weight:900;letter-spacing:1.8px;color:#1f2937;text-transform:uppercase;text-shadow:0 1px 0 rgba(255,255,255,0.55);transform:translateY(-6px);">GAMMA ELECTRONICS</span>
        <small style="display:inline-block;margin-top:4px;font-size:0.85rem;font-style:italic;color:#0f172a;opacity:0.85;">Where Great Deals Begin..</small>
      </div>
    </a>
    <nav class="site-nav" style="display:flex;align-items:center;gap:10px;">
      <a class="nav-pill" href="../views/index.php" style="display:inline-flex;align-items:center;justify-content:center;gap:8px;text-decoration:none;color:#0f172a;font-weight:700;background:#eef4ff;padding:0 14px;border-radius:999px;border:1px solid #cfe0ff;min-width:150px;height:48px;line-height:1;box-sizing:border-box;">
        <img src="../assests/images/login/home.png" alt="Home" style="width:28px;height:28px;object-fit:contain;" />
        Home
      </a>
      <?php
      if (!isset($_SESSION["user"])) {
      ?>
        <a id="" class="nav-pill auth-trigger" href="../views/login.php?showModel=1" style="display:inline-flex;align-items:center;justify-content:center;gap:8px;text-decoration:none;color:#0f172a;font-weight:700;background:#eef4ff;padding:0 14px;border-radius:999px;border:1px solid #cfe0ff;min-width:150px;height:48px;line-height:1;box-sizing:border-box;">
          Log In
        </a>
        <a id="" class="nav-pill auth-trigger" href="../views/login.php?showModel=2" style="display:inline-flex;align-items:center;justify-content:center;gap:8px;text-decoration:none;color:#0f172a;font-weight:700;background:#eef4ff;padding:0 14px;border-radius:999px;border:1px solid #cfe0ff;min-width:150px;height:48px;line-height:1;box-sizing:border-box;">
          Register
        </a>
      <?php
      } else {
        if($_SESSION["user_type"]==3){
          $filename="userProfile.php";
        }else if($_SESSION["user_type"]==2){
          $filename="sellerProfile.php";
        }else{
          $filename="#";
        }
      ?>
        <a id="profileBtn" class="nav-pill" href="../views/<?php echo $filename;?>" style="display:inline-flex;align-items:center;justify-content:center;gap:8px;text-decoration:none;color:#0f172a;font-weight:700;background:#eef4ff;padding:0 14px;border-radius:999px;border:1px solid #cfe0ff;min-width:150px;height:48px;line-height:1;box-sizing:border-box;">
          Profile
        </a>
        <a id="signOut_Btn" class="nav-pill" href="../config/logout.php" style="display:inline-flex;align-items:center;justify-content:center;gap:8px;text-decoration:none;color:#0f172a;font-weight:700;background:#eef4ff;padding:0 14px;border-radius:999px;border:1px solid #cfe0ff;min-width:150px;height:48px;line-height:1;box-sizing:border-box;">
          Sign Out
        </a>
      <?php
      }
      ?>

    </nav>
  </div>
</header>