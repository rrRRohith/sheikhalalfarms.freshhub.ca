$(document).on('click', '.paginate a', async function(e){
  e.preventDefault();
  let link = e.currentTarget.getAttribute('href');
  let key = $('input#table-search').val();
  let sort = sortDiv.attr('data-sort');
  let direction = sortDiv.attr('data-direction');
    if(link == null || link == '' || !link)
      return false;
    loadingRow();
  await $.getJSON(`${link}&key=${searchKey.val()}&sort=${sort}&direction=${direction}`, function(response) {
    renderTable(response);
  });
});