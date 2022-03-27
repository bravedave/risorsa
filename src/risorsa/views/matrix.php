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

use strings;

?>
<div class="table-responsive">
  <table class="table table-sm" id="<?= $_uidMatrix = strings::rand() ?>">
    <thead class="small">
      <tr>
        <td>computer</td>
        <td>purchase date</td>
        <td>computer name</td>
        <td>cpu</td>
        <td>memory</td>
        <td>hdd</td>
        <td>os</td>
      </tr>
    </thead>

    <tbody></tbody>

  </table>
</div>
<script>
  (_ => {

    const edit = function() {
      let _me = $(this);
      let _dto = _me.data('dto');

      _.get.modal(_.url(`<?= $this->route ?>/edit/${_dto.id}`))
        .then(m => m.on('success', e => _me.trigger('refresh')));

    };

    const matrix = data => {
      let table = $('#<?= $_uidMatrix ?>');
      let tbody = $('#<?= $_uidMatrix ?> > tbody');

      tbody.html('');
      $.each(data, (i, dto) => {
        $(`<tr class="pointer">
          <td class="js-computer">${dto.computer}</td>
          <td class="js-purchase_date">${dto.purchase_date}</td>
          <td class="js-computer_name">${dto.computer_name}</td>
          <td class="js-cpu">${dto.cpu}</td>
          <td class="js-memory">${dto.memory}</td>
          <td class="js-hdd">${dto.hdd}</td>
          <td class="js-os">${dto.os}</td>
        </tr>`)
          .data('dto', dto)
          .on('click', function(e) {
            e.stopPropagation();
            e.preventDefault();

            $(this).trigger('edit');

          })
          .on('edit', edit)
          .on('refresh', refresh)
          .appendTo(tbody);

      });

    };

    const refresh = function(e) {
      e.stopPropagation();

      let _me = $(this);
      let _dto = _me.data('dto');

      _.post({
        url: _.url('<?= $this->route ?>'),
        data: {
          action: 'get-by-id',
          id: _dto.id
        },

      }).then(d => {
        if ('ack' == d.response) {
          $('.js-computer', _me).html(d.data.computer);
          $('.js-purchase_date', _me).html(d.data.purchase_date);
          $('.js-computer_name', _me).html(d.data.computer_name);
          $('.js-cpu', _me).html(d.data.cpu);
          $('.js-memory', _me).html(d.data.memory);
          $('.js-hdd', _me).html(d.data.hdd);
          $('.js-os', _me).html(d.data.os);

        } else {
          _.growl(d);

        }
      });
    };

    $('#<?= $_uidMatrix ?>')
      .on('refresh', function(e) {
        _.post({
          url: _.url('<?= $this->route ?>'),
          data: {
            action: 'get-matrix'
          },
        }).then(d => {
          if ('ack' == d.response) {
            matrix(d.data);
          } else {
            _.growl(d);
          }
        });

      });

    $(document).ready(() => $('#<?= $_uidMatrix ?>').trigger('refresh'));

  })(_brayworth_);
</script>