<?php

$lang = 'ru';
include_once "langs.php";

error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();

$user = false;
include "./auth.php";

if ($_SESSION['access'] !== 'all') {
  if (strpos($_SESSION['access'], ',') !== false) {
    $langs = explode(',', $_SESSION['access']);
    $lang = $langs[0];
  } else {
    $langs = array($_SESSION['access']);
    $lang = $_SESSION['access'];
  }
}

if (isset($_REQUEST['lang']) && in_array($_REQUEST['lang'], $langs)) {
  $lang = $_REQUEST['lang'];
}

if (isset($_REQUEST['action'])) {
  switch ($_REQUEST['action']) {
    case 'save':
      $locale = $_POST['data'];
      file_put_contents('../js_langs/' . $lang . '.json', $locale);
      echo '{"success":true}';
      break;
  }
} else {
  $btn = 'text-white flex items-center justify-center px-4 w-auto h-12 bg-red-600 rounded-full hover:bg-red-700 active:shadow-lg mouse shadow transition ease-in duration-200 focus:outline-none';
?>
  <!DOCTYPE html>
  <html lang="ru">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style type="text/css">
      .photos img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
      }
    </style>
  </head>

  <body class="py-5">
    <div class="container mx-auto">
      <div id="app">
        <div class="w-full flex justify-between">
          <div>
            <select v-model="lang" class="px-4 py-2 mb-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600l">
              <? foreach ($langs as $lng) { ?>
                <option value="<?= $lng ?>" <? if ($lng === $lang) echo 'selected'; ?>><?= $lng ?></option>
              <? } ?>
            </select>
          </div>
          <?if($_SERVER['PHP_AUTH_USER'] === 'odmen'): ?><a class="underline text-blue-600" href="./stat.php">Stat</a><?endif;?>
        </div>
        <div>
          <table class="table-auto w-full mb-20">
            <tbody>
              <tr v-for="(item, key) in rulocale" :key="key" v-if="!['screen7-3img', 'screen7-5img', 'screen7-7img'].includes(key)">
                <td width="20%" class="text-right pr-10">{{ key }}</td>
                <td width="80%" class="p-3">
                  <template v-if="Array.isArray(item)">
                    <template v-for="(arr, aidx) in item">
                      <input type="text" v-model="locale[key][aidx]" class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-1/3 sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600">
                    </template>
                  </template>
                  <template v-else>
                    <div class="mb-1">{{ rulocale[key] }}</div>
                    <input type="text" v-model="locale[key]" class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600">
                  </template>
                </td>
              </tr>
            </tbody>
          </table>
          <div class="fixed bottom-2 right-1/2">
            <div class="<?= $btn ?> px-10" @click="save"><span>Save</span></div>
          </div>
          <div v-if="loading" class="fixed flex items-center justify-center inset-0 bg-white bg-opacity-70	text-4xl">Saving...</div>
        </div>
      </div>
    </div>
    <style>
      .table-auto tr:nth-child(even) {
        background-color: rgb(243 244 246);
      }
    </style>
    <script src="./axios.min.js"></script>
    <script src="./vue.js"></script>
    <script>
      var app = new Vue({
        el: '#app',
        data: {
          photos: ['','',''],
          loading: false,
          locale: {},
          rulocale: {},
          lang: '<?= $lang ?>',
        },
        watch: {
          lang() {
            document.location.href = document.location.pathname + "?lang=" + this.lang
          },
        },
        async beforeMount() {
          await this.getLocale();
        },
        methods: {
          async getLocale() {
            let link = `../js_langs/${this.lang}.json?v=${Math.random()}`;
            let response = await axios.get(link);
            this.locale = response.data;
            link = `../js_langs/ru.json?v=${Math.random()}`;
            response = await axios.get(link);
            this.rulocale = response.data;

            if (this.locale['screen7-3img'] !== '') this.photos[0] = this.locale['screen7-3img'];
            if (this.locale['screen7-5img'] !== '') this.photos[1] = this.locale['screen7-5img'];
            if (this.locale['screen7-7img'] !== '') this.photos[2] = this.locale['screen7-7img'];
          },

          crop(url, aspectRatio) {
            // we return a Promise that gets resolved with our canvas element
            return new Promise((resolve) => {
              // this image will hold our source image data
              const inputImage = new Image();

              // we want to wait for our image to load
              inputImage.onload = () => {
                // let's store the width and height of our image
                const inputWidth = inputImage.naturalWidth;
                const inputHeight = inputImage.naturalHeight;

                // get the aspect ratio of the input image
                const inputImageAspectRatio = inputWidth / inputHeight;

                // if it's bigger than our target aspect ratio
                let outputWidth = inputWidth;
                let outputHeight = inputHeight;
                if (inputImageAspectRatio > aspectRatio) {
                  outputWidth = inputHeight * aspectRatio;
                } else if (inputImageAspectRatio < aspectRatio) {
                  outputHeight = inputWidth / aspectRatio;
                }

                // calculate the position to draw the image at
                const outputX = (outputWidth - inputWidth) * 0.5;
                const outputY = (outputHeight - inputHeight) * 0.5;

                // create a canvas that will present the output image
                const outputImage = document.createElement('canvas');

                // set it to the same size as the image
                outputImage.width = outputWidth;
                outputImage.height = outputHeight;

                // draw our image at position 0, 0 on the canvas
                const ctx = outputImage.getContext('2d');
                ctx.drawImage(inputImage, outputX, outputY);
                resolve(outputImage.toDataURL("image/jpeg"));
              };

              // start loading our image
              inputImage.src = url;
            });
          },

          resizeImg(file) {
            return new Promise((resolve, reject) => {
              const img = document.createElement("img");
              const reader = new FileReader();
              reader.onload = async (e) => {
                const cropped = await this.crop(e.target.result, 1);

                img.onload = (ie) => {
                  // resize
                  var canvas = document.createElement('canvas');
                  var ctx = canvas.getContext("2d");
                  ctx.drawImage(img, 0, 0);

                  var MAX_WIDTH = 200;
                  var MAX_HEIGHT = 200;
                  var width = img.width;
                  var height = img.height;

                  if (width > height) {
                    if (width > MAX_WIDTH) {
                      height *= MAX_WIDTH / width;
                      width = MAX_WIDTH;
                    }
                  } else {
                    if (height > MAX_HEIGHT) {
                      width *= MAX_HEIGHT / height;
                      height = MAX_HEIGHT;
                    }
                  }
                  canvas.width = width;
                  canvas.height = height;
                  // var ctx = canvas.getContext("2d");
                  ctx.drawImage(img, 0, 0, width, height);

                  resolve(canvas.toDataURL("image/jpeg"));
                }
                img.src = cropped;
              }
              reader.readAsDataURL(file);
            });
          },

          async changeimg(event, idx) {
            this.loading = true
            let file = await this.resizeImg(event.target.files[0]);
            this.$set(this.photos, idx, file); //photos[idx] = file;
            this.$set(this.locale, 'screen7-' + (idx * 2 + 3) + 'img', file);
            this.loading = false;
          },

          getBase64(file) {
            return new Promise((resolve, reject) => {
              const reader = new FileReader();
              reader.readAsDataURL(file);
              reader.onload = () => resolve(reader.result);
              reader.onerror = (error) => reject(error);
            });
          },

          async save() {
            this.loading = true;
            const locale = JSON.stringify(this.locale, null, 2);
            const params = new URLSearchParams();
            params.append('data', locale);
            params.append('action', 'save');
            const response = await axios.post('<?= str_replace(dirname(__FILE__) . "/", "", __FILE__); ?>?lang=<?= $lang ?>', params);
            if (response.data.success) {
              this.getLocale();
            }
            this.loading = false;
          }
        }
      })
    </script>
  </body>

  </html>
<? } ?>
