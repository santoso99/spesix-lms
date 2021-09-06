$(document).ready(function(){

    $('.btn-remove-competency').on('click', function(e){
        e.preventDefault()
        $(this).parent().parent().remove()
    });

    $('#btnFilterKd').on('click', function(e){
        e.preventDefault()
        $('.alert-success').hide()
        $('.alert-danger').hide()

        fetch_data()
    });

    $(document).on("click", ".checkAll",function () {
        $(this).parents('.table').find('input:checkbox').prop('checked', this.checked)
    });

    $(document).on('click', '.pagination a', function(event){
        event.preventDefault()
        let page = $(this).attr('href').split('page=')[1]
        fetch_data(page)
    });

    function fetch_data(page = null)
    {
        let url;
        let subject_id = $('#subjectSelectBox').val()
        let grade_level = $('#gradeSelectBox').val()

        if(page == null)
        {
            url = "{!! route('competencies.filter') !!}";
        }
        else {
            url = "{!! route('competencies.filter') !!}?page="+page
        }

        $.ajax({
            url: url,
            data: {
                subject_id: subject_id,
                grade_level: grade_level,
            },
            beforeSend: function(){
                $('#KdData').html("<p class='text-center'>Sedang memuat...</p>");
            },
            success:function(data)
            {
                $('#KdData').html(data);
            },
            error:function(data){
                console.log(data['error'])
            }
        });
    }

    $(document).on('click', '#btnAddKdToTopic', function(e){
        let grabbed_competencies = new Array()
        e.preventDefault()

        $("#KdData input[name='competency_id[]']:checked").each(function () {
            grabbed_competencies.push([
                this.value,
                this.nextElementSibling.innerText,
            ])
        });

        if(grabbed_competencies.length > 0){
            let competency_list = ``;

            for(i=0;i<grabbed_competencies.length;i++)
            {
                competency_list += `<div class="row">
                        <div class="col-md-11 col-12 form-group">
                            <input type="hidden" name="competency_id[]" value="${grabbed_competencies[i][0]}"><textarea class="form-control" disabled>${grabbed_competencies[i][1]}</textarea>
                        </div>
                        <div class="col-md-1 col-12 form-group">
                            <button class="btn btn-danger btn-lg btn-remove-competency">
                                <span class="far fa-trash-alt"></span> Hapus
                            </button>
                        </div>
                    </div>`
            }

            $('#KdWrapper').append(competency_list)
        }
    });

    $(document).on('click', '#btnCreateKd', function(e){
        e.preventDefault()

        const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content')
        let subject_id = $('#addSubjectSelectBox').val()
        let grade_level = $('#addGradeSelectBox').val()
        let competency = $('#addCompetencyInput').val()

        if(competency == null){
            $('#competencyError').text('Kompetensi Dasar tidak boleh kosong')
        }
        else {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                },
                url: "{!! route('competencies.store') !!}",
                type: 'post',
                dataType: 'json',
                data: {
                    subject_id: subject_id,
                    grade_level: grade_level,
                    competency: competency,
                },
                beforeSend: function(){
                    $('#btnAddKdToTopic').prop('disabled',true)
                    $('#btnAddKdToTopic').html('Loading...')
                },
                success: function(response){
                    $('#btnAddKdToTopic').prop('disabled',false)
                    $('#btnAddKdToTopic').html('Simpan')
                    $('#KdDataModal').hide()
                    $('#KdWrapper').append(`<div class="row">
                        <div class="col-md-11 col-12 form-group">
                            <input type="hidden" name="competency_id[]" value="${response['competency_id']}"><textarea class="form-control" disabled>${competency}</textarea>
                        </div>
                        <div class="col-md-1 col-12 form-group">
                            <button class="btn btn-danger btn-lg btn-remove-competency">
                                <span class="far fa-trash-alt"></span> Hapus
                            </button>
                        </div>
                    </div>`)
                },
                error: function(response){
                    $('#btnAddKdToTopic').prop('disabled',false)
                    $('#btnAddKdToTopic').html('Simpan')
                    swal({
                        text: "Kompetensi Dasar gagal ditambahkan",
                        icon: "error",
                    });
                }
            })
        }
    });
});