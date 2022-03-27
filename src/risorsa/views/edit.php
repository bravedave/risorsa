<?php
/*
 * David Bray
 * BrayWorth Pty Ltd
 * e. david@brayworth.com.au
 *
 * MIT License
 *
*/

namespace risorsa;

use strings, theme;

$dto = $this->data->dto;

?>
<form id="<?= $_form = strings::rand() ?>" autocomplete="off">

  <input type="hidden" name="action" value="risorsa-save">
  <input type="hidden" name="id" value="<?= $dto->id ?>">

  <div class="modal fade" tabindex="-1" role="dialog" id="<?= $_modal = strings::rand() ?>" aria-labelledby="<?= $_modal ?>Label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header <?= theme::modalHeader() ?>">
          <h5 class="modal-title" id="<?= $_modal ?>Label"><?= $this->title ?></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <!-- --[computer]-- -->
          <div class="form-row">
            <div class="col-md-3 col-form-label">computer</div>
            <div class="col mb-2">
              <input type="text" class="form-control" name="computer" value="<?= $dto->computer ?>">

            </div>

          </div>

          <!-- --[purchase_date]-- -->
          <div class="form-row">
            <div class="col-md-3 col-form-label text-truncate">purchase date</div>
            <div class="col mb-2">
              <input type="date" class="form-control" name="purchase_date" value="<?= $dto->purchase_date ?>">

            </div>

          </div>

          <!-- --[computer_name]-- -->
          <div class="form-row">
            <div class="col-md-3 col-form-label text-truncate">computer name</div>
            <div class="col mb-2">
              <input type="text" class="form-control" name="computer_name" value="<?= $dto->computer_name ?>">

            </div>

          </div>

          <!-- --[cpu]-- -->
          <div class="form-row">
            <div class="col-md-3 col-form-label text-truncate">cpu</div>
            <div class="col mb-2">
              <input type="text" class="form-control" name="cpu" value="<?= $dto->cpu ?>">

            </div>

          </div>

          <!-- --[memory]-- -->
          <div class="form-row">
            <div class="col-md-3 col-form-label text-truncate">memory</div>
            <div class="col mb-2">
              <input type="text" class="form-control" name="memory" value="<?= $dto->memory ?>">

            </div>

          </div>

          <!-- --[hdd]-- -->
          <div class="form-row">
            <div class="col-md-3 col-form-label text-truncate">hdd</div>
            <div class="col mb-2">
              <input type="text" class="form-control" name="hdd" value="<?= $dto->hdd ?>">

            </div>

          </div>

          <!-- --[os]-- -->
          <div class="form-row">
            <div class="col-md-3 col-form-label text-truncate">os</div>
            <div class="col mb-2">
              <input type="text" class="form-control" name="os" value="<?= $dto->os ?>">

            </div>

          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </div>
    </div>
  </div>
  <script>
    (_ => $('#<?= $_modal ?>').on('shown.bs.modal', () => {
      $('#<?= $_form ?>')
        .on('submit', function(e) {
          let _form = $(this);
          let _data = _form.serializeFormJSON();

          _.post({
            url: _.url('<?= $this->route ?>'),
            data: _data,

          }).then(d => {
            if ('ack' == d.response) {
              $('#<?= $_modal ?>')
                .trigger('success')
                .modal('hide');
            } else {
              _.growl(d);

            }

          });

          // console.table( _data);

          return false;
        });
    }))(_brayworth_);
  </script>
</form>