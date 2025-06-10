<!-- Select Template Component -->
<style>
  .modal-fullscreen {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.7);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 1050;
  }
  .modal-content-custom {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    max-width: 90%;
    max-height: 90%;
    overflow-y: auto;
  }
  .template-grid {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
  }
  .template-thumb {
    cursor: pointer;
    margin: 10px;
    border: 2px solid transparent;
    transition: border-color 0.2s;
    width: 200px;
  }
  .template-thumb:hover {
    border-color: #007bff;
  }
</style>

<div id="templateModal" class="modal-fullscreen">
  <div class="modal-content-custom">
    <h4>Select a Template</h4>
    <div class="template-grid">
      <?php if($result_templates && $result_templates->num_rows > 0): ?>
        <?php while($tpl = $result_templates->fetch_assoc()): ?>
          <div class="text-center">
            <?php if(!empty($tpl['preview_image'])): ?>
              <img src="<?= htmlspecialchars($tpl['preview_image']) ?>" alt="<?= htmlspecialchars($tpl['template_name']) ?>" class="template-thumb" data-file="<?= htmlspecialchars($tpl['file_path']) ?>">
            <?php else: ?>
              <div class="template-thumb" data-file="<?= htmlspecialchars($tpl['file_path']) ?>" style="background:#eee; height:150px; line-height:150px;">No Image</div>
            <?php endif; ?>
            <p><?= htmlspecialchars($tpl['template_name']) ?></p>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p>No templates available.</p>
      <?php endif; ?>
    </div>
    <button class="btn btn-secondary mt-3" id="closeTemplateModal">Cancel</button>
  </div>
</div>

<script>
$(document).ready(function(){
  $(document).on("click", "#openTemplateModal", function(){
      $("#templateModal").css("display", "flex").hide().fadeIn("fast");
  });
  $(document).on("click", "#closeTemplateModal", function(){
      $("#templateModal").fadeOut("fast", function(){
          $(this).css("display", "none");
      });
  });
  $(document).on("click", ".template-thumb", function(){
      const file = $(this).data("file");
      $("#selectedTemplate").val(file);
      $("#templateModal").fadeOut("fast", function(){
          $(this).css("display", "none");
      });
      if(typeof updatePreview === "function"){
          updatePreview();
      }
  });
});
</script>
