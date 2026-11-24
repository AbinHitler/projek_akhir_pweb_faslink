$(function(){
  $('#sidebarToggle').on('click',function(){ $('#appSidebar').toggleClass('open'); if(!$('.sidebar-backdrop').length){$('body').append('<div class="sidebar-backdrop"></div>')} $('.sidebar-backdrop').toggleClass('show'); });
  $(document).on('click','.sidebar-backdrop',function(){ $('#appSidebar').removeClass('open'); $(this).removeClass('show'); });
  $('#facilitySearch, #tableSearch').on('input',function(){let q=$(this).val().toLowerCase();let target=$(this).attr('id')==='facilitySearch'?'.facility-item':'tbody tr';$(target).each(function(){$(this).toggle($(this).text().toLowerCase().includes(q));});});
  $('#facilityType').on('change',function(){let v=$(this).val();$('.facility-item').each(function(){$(this).toggle(v==='all'||$(this).data('type')===v);});});
  $('[data-status-filter]').on('click',function(){let v=$(this).data('status-filter');$('[data-status-filter]').removeClass('active');$(this).addClass('active');$('#loanRows tr').each(function(){$(this).toggle(v==='all'||$(this).data('status')===v);});});
  $('[data-table-filter]').on('click',function(){let v=$(this).data('table-filter');$('[data-table-filter]').removeClass('active');$(this).addClass('active');$('#adminFacilityRows tr').each(function(){$(this).toggle(v==='all'||$(this).data('type')===v);});});
  $('.demo-form').on('submit',function(e){e.preventDefault();if(this.reportValidity()){alert($(this).data('success')||'Data berhasil disimpan (demo).');}});
  $(document).on('click','[data-confirm]',function(){if(confirm($(this).data('confirm'))){alert('Aksi simulasi berhasil. Belum tersambung ke backend.');}});
});
