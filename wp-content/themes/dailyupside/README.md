
  <h1><code>WordPress Gulp Workflow</code></h1>

🎯 An advanced & extensively documented Gulp WordPress workflow. Kick-start a build-workflow for your WordPress plugins and themes with Gulp.

This is a fork of the this [project](https://github.com/ahmadawais/WPGulp)

## 📦 WPGulp Can Do `THAT™`

`WPGulp` is an advanced & extensively documented `Gulp.js` + `WordPress` workflow. It can help you kick-start a build-workflow for your WordPress plugins and themes with `Gulp.js`, save you a lot of grunt work time, follow the DRY (Don't Repeat Yourself) principle, and `#0CJS` Zero-config JavaScript startup but still configurable via `wpgulp.config.js` file. It is:

- 🥞 Versioned ✓
- 🤠 Updatable ✓
- 🗃 Set of sane-defaults ✓

<br>

💻 **DEV ENVIRONMENT**

>- _Live reload browser with BrowserSync_
>- _Hotloading styles with CSS Injection_

🎨 **STYLES**

>- _Sass to CSS conversion_
>- _Merging media queries_
>- _Error handling_
>- _Auto-prefixing_
>- _Minification_
>- _Sourcemaps_

🌋 **JavaScript**

>- _Concatenation_
>- _Minification/uglification_
>- _Separate vendor and custom JS files handling_

🌁 **IMAGES**

>- _Minification/optimization of images_
>- _File types: `.png`, `.jpg`, `.jpeg`, `.gif`, `.svg`_

💯 **TRANSLATION**

>- _Generates `.pot` translation file for i18n and l10n_

👀 **WATCHING**

>- _For changes in files to recompile_
>- _File types: `.css`, `.html`, `.php`, `.js`_

<br>

![Start](https://a.cl.ly/83f7dd38eb83/c)

## Getting Started

#### ⚡️ Quick Overview

Run step `#1`, `#2`, and `#3` quickly in one go — Run inside local WP install's theme/plugin folder E.g. `/wp.local/wp-content/plugins/your-plugin` or `/wp.local/wp-content/themes/your-theme` directory.

```sh
# 1— Install WPGulp in your WordPress wp-content/themes/your-theme
npm install
# 2— Now configure variables inside the `wpgulp.config.js` file.
# 3— Start your npm build workflow.
npm start
```



In case you are an absolute beginner to the world of `Node.js`, JavaScript, and `npm` packages — all you need to do is go to the Node's site [download + install](https://nodejs.org/en/download/) Node on your system. This will install both `Node.js` and `npm`, i.e., node package manager — the command line interface of Node.js.

You can verify the install by opening your terminal app and typing...

```sh
node -v
# Results into v9.11.2 — make sure you have Node >= 8 installed.

npm -v
# Results into 6.2.0 — make sure you have npm >= 5.3 installed.
```

</details>

### → `STEP #1` — Get the Required Files

1. In the terminal go to the root folder of your WordPress theme
2. Copy the WPGulp project into your theme directory.

_It'll take a couple of minutes to install._

```sh
npm install
```


![wpgulp install gif](https://a.cl.ly/c846c265e03a/c)

> ⚠️  I'm assuming that there are no previously present similar files in the root of your folder. Otherwise, you need to merge these very carefully. E.g. You can include the `scripts`, `devDependencies` in your current `package.json` file and so on for other files. If you run the above command all similar files will be overwritten.

### → `STEP #2` — Editing the Project Variables

Configure the project paths and other variables inside the `wpgulp.config.js` file. This is a compulsory step.

![wpgulp config](https://a.cl.ly/f2ca9bb4a740/c)

### → `STEP #3` — Start your project

Once the installation is done, you can open your project (WordPress plugin/theme) folder and run the start script.

```sh
npm start

# To stop press CTRL (⌃) + C
```

![wpgulp start](https://a.cl.ly/d64abd87de1f/c)

### → `OPTIONAL STEP #4` — More Scripts/Tasks

To optimize images and generate WP POT translation file, or generate a RTL stylesheet you can run the following commands

```sh
# To optimize images.
npm run images

# To generate WP POT translation file.
npm run translate

# To generate RTL stylesheets and Sourcemap.
npm run styles-rtl

# To generate theme/plugin zip file without extranious files.
npm run zip
```

<br>
