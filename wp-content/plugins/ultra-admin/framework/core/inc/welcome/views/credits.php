<div class="wrap about-wrap">
    <h1><?php _e( 'Redux Framework - A Community Effort', 'ultra_framework' ); ?></h1>

    <div
        class="about-text"><?php _e( 'We recognize we are nothing without our community. We would like to thank all of those who help Redux to be what it is. Thank you for your involvement.', 'ultra_framework' ); ?></div>
    <div
        class="redux-badge"><i
            class="el el-redux"></i><span><?php printf( __( 'Version %s', 'ultra_framework' ), ReduxFramework::$_version ); ?></span>
    </div>

    <?php $this->actions(); ?>
    <?php $this->tabs(); ?>

    <p class="about-description"><?php _e( 'Redux is created by a community of developers world wide. Want to have your name listed too? <a href="https://github.com/reduxframework/ultra_framework/blob/master/CONTRIBUTING.md" target="_blank">Contribute to Redux</a>.', 'ultra_framework' ); ?></p>

    <?php echo $this->contributors(); ?>
</div>