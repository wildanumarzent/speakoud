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
        .preloader-wrap{
            position: fixed; 
            top:0; 
            left:0; 
            right:0; 
            bottom:0; 
            background-color: 
            rgba(0, 0, 0, 0.7)
        }
        .loader{ 
            width: 
            110px; 
            height: 110px; 
            border-radius:50%; 
            background-color: rgb(255, 255, 255); 
            position:relative;
             overflow:hidden; 
             left:0; right:0; 
             top:50%; 
             transform:translateY(-50%);
              margin:0 auto;
            }
        .trackbar { width: 110px;
            height: 110px;
            margin: 0 auto;
            background-color: rgb(255, 255, 255);
            padding: 0;
            position: absolute; 
            border-radius: 50%;
            left: 0;
            right: 0;
            top: 50%; 
            transform:translateY(-50%)
        }
        .loadbar{ position: absolute; 
            bottom: 0; 
            left: 0; 
            right: 0; 
            background-color: skyblue; 
        }
        .trackbar:after{
            content:''; position:absolute; 
            top:50%; 
            left:0%; 
            right:0; 
            margin:0 auto;
            width:90px; 
            height:90px; 
            /* background-color: rgb(0, 0, 0); */
            /* background-image: url('/assets/img/speakoud.png');  */
            background-repeat: no-repeat; 
            background-size: 100%; 
            text-align: center; 
            border-radius: 50%;
            transform: translateY(-50%);}
           
             #pdf-render{
            /* border: solid 1px blue;   */
            width: 100%;
            height: 100%;
            }
            img{
                vertical-align: middle;
                border-style: none;
                display: block;
                margin-left: auto;
                margin-right: auto;
                width: 50%
            }
    </style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">    
      <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    </head>
    <body>
    <div class="preloader-wrap">
        <div class="loader">
            <div class="trackbar">
                <div class="loadbar">
                    {{-- <p style="text-align: center">Mohon tunggu...</p>  --}}
                    <img src="{{url('/assets/img/speakoud.png')}}" width="50px" alt="">
                </div>
            </div>
        </div>
    </div>

    <canvas id="pdf-render" class="d-flex justify-content-center"></canvas>
        <div class="top-bar" style="text-align: center; margin-top:10px">
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
           
   
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
    <script src="js/main.js"></script> 
    <script>
        var height = 100,
        perfData = window.performance.timing, // The PerformanceTiming interface represents timing-related performance information for the given page.
        EstimatedTime = -(perfData.loadEventEnd - perfData.navigationStart),
        time = parseInt((EstimatedTime/1000)%60)*100;
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
            //  Loadbar Animation
            var test = $(".loadbar").animate({
            height: height + "%"
            }, duration);
            // Fading Out Loadbar on Finised
            setTimeout(function(){
            $('.preloader-wrap').fadeOut(500);
            }, duration);
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