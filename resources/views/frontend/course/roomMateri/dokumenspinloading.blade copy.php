<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
     <link rel="shortcut icon" type="image/png" href="{{ asset('assets/tmplts_backend/images/speakoud.png') }}" sizes="32x32">
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
      integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="css/style.css" />
    <title>MATERI</title>
    <style>
        * {
        margin: 0;
        padding: 0;
        }

        .top-bar {
            background: #333;
            color: #fff;
            padding: 1rem;
        }

        .btn {
        background: coral;
        color: #fff;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 0.7rem 2rem;
        }

        .btn:hover {
        opacity: 0.9;
        }

        .page-info {
        margin-left: 1rem;
        }

        .error {
        background: orangered;
        color: #fff;
        padding: 1rem;
        }
        #pdf-render{
        /* border: solid 1px blue;   */
        width: 100%;
        height: 100%;
        }
        .preload { width:100px;
        height: 100px;
        position: fixed;
        top: 50%;
        left: 50%;
        }
        .container {display:none;}
        
    </style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">    
      <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>
  <body>
   {{-- {{ dd(route('bank.data.stream', ['path' => $data['bahan']->dokumen->bankData->file_path])) }} --}}
   <div class="preload"><img src="http://i.imgur.com/KUJoe.gif">
    </div>
   <div class="container">
    <div class="row">
        <div class="col-md-12">
            <canvas id="pdf-render"></canvas>
                 <div class="top-bar" style="text-align: center">
                  <button class="btn" id="prev-page">
                    <i class="fas fa-arrow-circle-left"></i> Prev Page
                  </button>
                    <button class="btn" id="next-page">
                      Next Page <i class="fas fa-arrow-circle-right"></i>
                    </button>
                    <br>
                    <div id="is_read" style="padding-top: 10px">
                    </div>
                  <span class="page-info">
                    Page <span id="page-num"></span> of <span id="page-count"></span>
                  </span>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
    <script src="js/main.js"></script> 
    <script>
        // document.ready(function () {
        // $("#readed").css("display:block");
            
        // })
    </script>
    <script>
        // const url = '../docs/pdf.pdf';
        const url = "{{ route('bank.data.stream', ['path' => $data['bahan']->dokumen->bankData->file_path]) }}";
        console.log(url);
        let pdfDoc = null,
        pageNum = 1,
        pageIsRendering = false,
        pageNumIsPending = null;

        const scale = 1.5,
        canvas = document.querySelector('#pdf-render'),
        ctx = canvas.getContext('2d');

        const renderPage = num => {
        pageIsRendering = true;

        // Get page
        pdfDoc.getPage(num).then(page => {
            const viewport = page.getViewport({ scale });
            canvas.height = viewport.height;
            canvas.width = viewport.width;
            
            const renderCtx = {
            canvasContext: ctx,
            viewport
            };

            page.render(renderCtx).promise.then(() => {
            pageIsRendering = false;

            if (pageNumIsPending !== null) {
                renderPage(pageNumIsPending);
                pageNumIsPending = null;
            }
            });

            // Output current page
            document.querySelector('#page-num').textContent = num;
            // alert(test);
        });
        };

        // Check for pages rendering
        const queueRenderPage = num => {
        if (pageIsRendering) {
            pageNumIsPending = num;
        } else {
            renderPage(num);
        }
        };

        // Show Prev Page
        const showPrevPage = () => {
        if (pageNum <= 1) {
            return;
        }
        pageNum--;
        queueRenderPage(pageNum);
        };

        // Show Next Page
        const showNextPage = () => {
            if (pageNum >= pdfDoc.numPages) {
                var finish = document.getElementById('is_read');
                finish.innerHTML = '<button class="btn" onclick="isRead()" id="next-page">Selesai Membaca<i class="fas fa-arrow-circle-right"></i></button>';    
            }
            pageNum+pageNum+1;
            queueRenderPage(pageNum);

            console.log(pageNum++);
        };

        // get document
        var url_src = pdfjsLib.getDocument(url);
        console.log(url_src);
        url_src.onProgress = function(data){
            var duration = data.loaded / data.total;
            console.log(duration);
            $(".preload").fadeOut(duration, function() {
                $(".container").fadeIn(1000);        
            });
        }

        url_src
        .promise.then(pdfDoc_ => {
            pdfDoc = pdfDoc_;
            document.querySelector('#page-count').textContent = pdfDoc.numPages;

            renderPage(pageNum);
        })
        .catch(err => {
            // Display error
            const div = document.createElement('div');
            div.className = 'error';
            div.appendChild(document.createTextNode(err.message));
            document.querySelector('body').insertBefore(div, canvas);
            // Remove top bar
            document.querySelector('.top-bar').style.display = 'none';
        });

        // Button Events
        document.querySelector('#prev-page').addEventListener('click', showPrevPage);
        document.querySelector('#next-page').addEventListener('click', showNextPage);
        function isRead() { 
            var bahanId = "{{$data['bahan']->id}}";
            // console.log(bahanId);
            // alert(bahanId)
            $.ajax({
                type:'GET',
                url:'/read/'+bahanId+'/complite',
                data:{
                    "_token": "{{ csrf_token() }}",
                    id:bahanId, 
                },
                success:function(data){
                    // console.log(data.data.mata_id);
                    window.location.href='/pelatihan/'+data.data.mata_id+'/detail';
                }
            });
        }
    
      
    </script>
    
    </body>
</html>