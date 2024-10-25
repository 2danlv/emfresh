/**
 * class importer
 */
jQuery(function($){

    $('.em-importer').each(function(){
        let em = $(this),
            em_name = em.data('name') || '';

        if(em_name == '') return;
        
        $('.js-import', em).on('click', function(e){
            e.preventDefault();

            let file = null;

            $('.js-file').each(function(){
                if(this.files.length>0) {
                    file = this.files[0];
                }
            });

            if(file == null) {
                alert('Vui lòng chọn file excel!');

                return;
            }

            if(typeof XLSX == 'undefined') {
                return alert('XLSX not found!');
            }
    
            const reader = new FileReader();
            reader.readAsArrayBuffer(file);
            reader.onload = function (e) {
                var workbook = XLSX.read(e.target.result, {
                    type: 'binary'
                });
    
                let raw_data = [];
        
                workbook.SheetNames.forEach((sheetName, index) => {
                    if(index > 0) return;
    
                    raw_data = XLSX.utils.sheet_to_json(workbook.Sheets[sheetName], {header: 1});
                });
                
                if(raw_data.length>0) {
                    var p = $('.js-import', em), tid = 0;

                    if(p.hasClass('loading')) return;
                    p.addClass('loading');
                    
                    // $('.js-file').val('');

                    $.post('?', {
                        import: em_name, 
                        importoken: $('#importoken').val(),
                        data: raw_data
                    }, function(response){
                        p.removeClass('loading');
                        if(tid > 0) {
                            clearTimeout(tid);
                        }

                        let rows = [], results = response.data;

                        Object.keys(results).forEach(row => {
                            let row_res = results[row], error = '';

                            if(row_res.code == 400) {
                                error = ` (${row_res.data})`;
                            }

                            rows.push(`Dòng ${row}: ${row_res.message}${error}.`);
                        });

                        console.log('import.response', response);

                        alert("Kết quả:\n\n" + rows.join("\n"));
                    }, 'json');

                    tid = setTimeout(function(){
                        p.removeClass('loading');
                    }, 30000);
                } else {
                    alert('NO data to Import');
                }
            };
            
            reader.onerror = function (error) {
                console.log('Error: ', error);
            };
        });

        $('.js-export', em).on('click', function(e){
            e.preventDefault();

            if(typeof XLSX == 'undefined') {
                return alert('XLSX not found!');
            }

            let p = $(this), tid = 0;

            if(p.hasClass('loading')) return;
            p.addClass('loading');

            $.post('?', {
                export: em_name, 
                importoken: $('#importoken').val()
            }, function(res){
                p.removeClass('loading');
                if(tid > 0) {
                    clearTimeout(tid);
                }

                if(res.code && res.code == 200) {
                    // console.log('data', res.data);
                    let rows = res.data,
                        time = (new Date()).getTime();

                    /* generate worksheet and workbook */
                    const worksheet = XLSX.utils.json_to_sheet(rows);
                    const workbook = XLSX.utils.book_new();
                    XLSX.utils.book_append_sheet(workbook, worksheet, em_name);
                    
                    /* create an XLSX file and try to save to Donwload.xlsx */
                    XLSX.writeFile(workbook, `${em_name}-${time}.xlsx`, { compression: true });
                }
            }, 'json');

            tid = setTimeout(function(){
                p.removeClass('loading');
            }, 30000);
        });
    });
});