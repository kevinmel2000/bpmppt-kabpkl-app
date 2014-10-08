$('.charts').each(function () {
  "use strict";

  /*global Morris*/
  Morris.Donut({
    element: $(this).attr('id'),
    data: [
      {label: "Pending", value: $(this).data('pending')},
      {label: "Approved", value: $(this).data('approved')},
      {label: "Deleted", value: $(this).data('deleted')},
      {label: "Done", value: $(this).data('done')}
    ]
  });
});
