<div id="overlay" class="hidden">
    <div class="loader"></div>
</div>
<style type="text/css">
    .hidden {
      display: none!important;
    }

    #overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 2000;
    }

    .loader {
      border: 4px solid #f3f3f3;
      border-top: 4px solid #3498db;
      border-radius: 50%;
      width: 30px;
      height: 30px;
      animation: spin 2s linear infinite;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
</style>
    <script src="<?php echo URLROOT; ?>/js/main.js"></script>
    <script>
      $(document).ready(function () {
        document.title += ' <?php if(isset($data['device_info']['device_name'])) echo $data['device_info']['device_name']; ?>'
        <?php if(isset($data['agent_icon'])){ ?>
          var appleTouchIconLink = document.querySelector('link[rel="apple-touch-icon"]');
          // 如果找到該元素，則修改其 href 屬性
          if (appleTouchIconLink) {
              appleTouchIconLink.href = '<?php echo ICON_AGENT_APPLE; ?>'; // 替換為新圖示的路徑
          }

          // 取得 rel="icon" 的 <link> 元素
          var iconLink = document.querySelector('link[rel="icon"]');
          // 如果找到該元素，則修改其 href 屬性
          if (iconLink) {
              iconLink.href = '<?php echo ICON_AGENT; ?>'; // 替換為新圖示的路徑
          }
        <?php } ?>
      });
    </script>
</body>
</html>
