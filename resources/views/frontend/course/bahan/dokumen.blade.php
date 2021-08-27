<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
      integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="css/style.css" />
    <title>PDF Viewer</title>
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
        border: solid 1px blue;  
        width: 100%;
        }
    </style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">    
  </head>
  <body>
   
    <div class="row">
        <div class="col-md">
            <div class="container">
                <canvas id="pdf-render"></canvas>

                 <div class="top-bar" style="text-align: center">
                  <button class="btn" id="prev-page">
                    <i class="fas fa-arrow-circle-left"></i> Prev Page
                  </button>
                  <button class="btn" id="next-page">
                    Next Page <i class="fas fa-arrow-circle-right"></i>
                  </button>
                  <span class="page-info">
                    Page <span id="page-num"></span> of <span id="page-count"></span>
                  </span>
                </div>

            </div>
        </div>
    </div>
    <script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
    <script src="js/main.js"></script>
    <script>
        // const url = '../docs/pdf.pdf';
        const url = "{{ route('bank.data.stream', ['path' => $data['bahan']->dokumen->bankData->file_path]) }}";

        let pdfDoc = null,
        pageNum = 1,
        pageIsRendering = false,
        pageNumIsPending = null;

        const scale = 1.5,
        canvas = document.querySelector('#pdf-render'),
        ctx = canvas.getContext('2d');

        // Render the page
        const renderPage = num => {
        pageIsRendering = true;
            // console.log();
        // Get page
        pdfDoc.getPage(num).then(page => {
            // Set scale
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
            return;
        }
        pageNum++;
        queueRenderPage(pageNum);
        };

        // Get Document
        pdfjsLib
        .getDocument(url)
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
    </script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>