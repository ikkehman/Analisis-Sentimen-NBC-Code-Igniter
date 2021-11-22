<div class="sidebar">
        <div class="scroll-wrapper scrollbar-inner sidebar-wrapper" style="position: relative;"><div class="scrollbar-inner sidebar-wrapper scroll-content scroll-scrolly_visible" style="height: auto; margin-bottom: 0px; margin-right: 0px; max-height: 588px;">
          <div class="user">
            <div class="photo">
              <a href="#!user"><img src="<?php echo base_url('assets/images/') . $this->session->userdata('avatar'); ?>"></a>
            </div>
            <div class="info">
              <a class="" data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                <span>
                  <?php echo ucwords(strtolower($this->session->userdata('nama'))); ?>
                  <span class="user-level"><?php echo ucwords(strtolower($this->session->userdata('level'))); ?></span>
                  <span class="caret"></span>
                </span>
              </a>
              <div class="clearfix"></div>

              <div class="collapse in" id="collapseExample" aria-expanded="true" style="">
                <ul class="nav">
                  <li>
                    <a href="<?php echo base_url('profile'); ?>">
                      <span class="link-collapse">My Profile</span>
                    </a>
                  </li>
                  <li>
                    <a href="#settings">
                      <span class="link-collapse">Settings</span>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <ul class="nav">
            <li class="nav-item">
              <a href="<?php echo base_url('dashboard'); ?>">
                <i class="la la-home"></i>
                <p>Dashboard</p>
              </a>
            </li>

            <hr />
<?php if($this->session->userdata('level') == 'administrator'): ?>
              <div class="subheader" style="color: 575962;">
              Admin Menu</div>

            <li class="nav-item">
              <a href="<?php echo base_url('kandas'); ?>">
                <i class="la la-book"></i>
                <p>Kata Dasar</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?php echo base_url('stopword'); ?>">
                <i class="la la-minus-circle"></i>
                <p>Stopword</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?php echo base_url('normalisasi'); ?>">
                <i class="la la-search"></i>
                <p>Normalisasi</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?php echo base_url('latihan'); ?>">
                <i class="la la-comments"></i>
                <p>Data Latih</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('single'); ?>">
                <i class="la la-check-circle"></i>
                <p>Single Analysis</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('multi'); ?>">
                <i class="la la-list-alt"></i>
                <p>Batch Analysis</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('valid'); ?>">
                <i class="la la-pie-chart"></i>
                <p>Pengujian</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('users'); ?>">
                <i class="la la-users"></i>
                <p>Users</p>
              </a>
            </li>
        <hr />
    <?php endif; ?>

<?php if($this->session->userdata('level') !== 'administrator'): ?>
              <div class="subheader">Menu</div>

            <li class="nav-item">
              <a href="<?php echo base_url('latihan/multi'); ?>">
                <i class="la la-comments"></i>
                <p>Validasi</p>
              </a>
            </li>
            <hr/>
    <?php endif; ?>


            <li class="nav-item">
              <a href="<?php echo base_url('auth/logout'); ?>">
                <i class="la la-sign-out"></i>
                <p>Keluar</p>
              </a>
            </li>
          </ul>
        </div><div class="scroll-element scroll-x scroll-scrolly_visible"><div class="scroll-element_outer"><div class="scroll-element_size"></div><div class="scroll-element_track"></div><div class="scroll-bar" style="width: 88px;"></div></div></div><div class="scroll-element scroll-y scroll-scrolly_visible"><div class="scroll-element_outer"><div class="scroll-element_size"></div><div class="scroll-element_track"></div><div class="scroll-bar" style="height: 489px; top: 0px;"></div></div></div></div>
      </div>