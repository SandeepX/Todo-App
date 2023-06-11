
<script>
    $('document').ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#image').change(function(){
            const input = document.getElementById('image');
            const preview = document.getElementById('image-preview');
            const file = input.files[0];
            const reader = new FileReader();
            reader.addEventListener('load', function() {
                preview.src = reader.result;
            });
            reader.readAsDataURL(file);
            $('#image-preview').removeClass('d-none')

        })

        $('body').on('change','#toggleTodoStatus',function (event) {
            event.preventDefault();
            let status = $(this).prop('checked') ? 1 : 0
            let params = {
                status: (status == 1) ? 'completed' : 'progress'
            };
            let href = $(this).data('href');
            let queryString = $.param(params);
            let urlWithParams = href + "?" + queryString
            Swal.fire({
                title: 'Are you sure you want to change Todo status to ' + params.status + ' ?',
                showDenyButton: true,
                confirmButtonText: `Yes`,
                denyButtonText: `No`,
                padding:'10px 50px 10px 50px',
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = urlWithParams;
                }else if (result.isDenied) {
                    (status === 0)? $(this).prop('checked', true) :  $(this).prop('checked', false)
                }
            })
        })

        $('body').on('click', '.showTodoDetail', function (e) {
            e.preventDefault();
            let title = $(this).data('title');
            let description = $(this).data('description');
            let status = $(this).data('status');
            let imagePath = $(this).data('image');
            let deadline = $(this).data('deadline');
            $('.modal-title').html(title);
            $('.description').text(description);
            $('.deadline').text(deadline);
            $(".image").attr("src", imagePath);
            $('.status').text(status);
            $('#addslider').modal('show');
        });


        $('.delete').click(function (event) {
            event.preventDefault();
            let href = $(this).data('href');
            Swal.fire({
                title: 'Are you sure you want to Delete Todo Detail ?',
                showDenyButton: true,
                confirmButtonText: `Yes`,
                denyButtonText: `No`,
                padding:'10px 50px 10px 50px',
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = href;
                }
            })
        })
    })








</script>
