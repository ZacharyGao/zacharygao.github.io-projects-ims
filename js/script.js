window.$docsify = {
    name: 'CS with AI',
    // repo: 'zacharyGao',
    rootPath: 'content/',
    
    el: '#app', // 欢迎页
    // coverpage: true, // 封面
    coverpage: {
        // '/': '/inc/cover.md',
        // '/zh-cn/': 'cover.md'
    },
    loadSidebar: true, // 侧边栏
    // loadNavbar: true, // 导航栏
    topMargin: 40, // 让你的内容页在滚动到指定的锚点时，距离页面顶部有一定空间
    mergeNavbar: true,  // 小屏设备下合并导航栏到侧边栏
    auto2top: true, // 自动回到顶部
    maxLevel: 3, // 最大标题层级
    subMaxLevel: 2, // 每个标题下面的最大标题层级
    // search: 'auto', // 搜索
    search: {
        maxAge: 86400000, // 过期时间，单位毫秒，默认一天
        paths: 'auto', // or 'auto'
        placeholder: 'search',
        noData: 'No Results!',
        depth: 3 // 搜索标题的最大层级, 1 - 6
    },
    pagination: {
        previousText: 'Prev', // 上一页按钮文字
        nextText: 'Next', // 下一页按钮文字
        crossChapter: true, // 在章节之间显示分页
        crossChapterText: true // 文章之间显示分页
    },
    plugins: [
        // function (hook, vm) {
        //     hook.beforeEach(function (html) {
        //         var url = vm.route.file
        //         var editHtml = '[📝 EDIT DOCUMENT](' + url + ')\n'
        //         // console.log(url)
        //         // console.log(editHtml)
        //         // var html = html.replace(/<h1.*?>(.*?)<\/h1>/, function (match, submatch) {
        //         //     return '<h1>' + submatch + '</h1>' + editHtml
        //         // })
        //         // var html = "https://github.com/zacharyGao/zacharyGao.github.io/blob/master/docs/README.md"
        //         // console.log(html)
        //         // return editHtml + html
        //         return html
        //     })
        // },
        function (hook, vm) {
            hook.beforeEach(function (html) {
                // var url = vm.route.file
                // const headingRegex = /^#\s+(.+)$/gm;
                const regex = /^#\s.*/gm; // 匹配每行的一级标题
                return html.replace(regex, match => match + "<!--{docsify-ignore-all} -->");

                // // var newhtml = html.replace(/# .*? /, "# match")
                // var newhtml = html.replace(headingRegex, '# $1 <!--{docsify-ignore-all}-->\n');
                // console.log(newhtml)                
                // // return newhtml
                // return html
            })
        }
    ],
    // executeScript: true, // 执行 script 标签中的脚本
    formatUpdated: '{YYYY}-{MM}-{DD} {HH}:{mm}', // 格式化更新时间
    formatUpdated: '{MM}/{DD} {HH}:{mm}', // 格式化更新时间

    toc: {
        scope: '.markdown-section',
        headings: 'h1, h2, h3, h4, h5, h6',
        title: 'Table of Contents',
    },

    alias: {
        '/.*/_sidebar.md': '/_sidebar.md'
    },
    // relativePath: true, // 启用相对路径
    // basePath: '/docs/', // 基础路径

    // 404 页面
    notFoundPage: true, // 404 页面
    notFoundPage: {
        '/': '/inc/404.md'
    },
    // 403 页面
    // forbiddenPage: true, // 403 页面
    // forbiddenPage: {
    //     '/': 'custom-403.md'
    // },
    // 500 页面
    // internalServerErrorPage: true, // 500 页面
    // internalServerErrorPage: {
    //     '/': 'custom-500.md'
    // },
    // 401 页面
    // unauthorizedPage: true, // 401 页面
    // unauthorizedPage: {
    //     '/': 'custom-401.md'
    // },
    // 503 页面
    // serviceUnavailablePage: true, // 503 页面
    // serviceUnavailablePage: {
    //     '/': 'custom-503.md'
    // },
    // 400 页面
    // badRequestPage: true, // 400 页面
    // badRequestPage: {
    //     '/': 'custom-400.md'
    // },
    // 402 页面
    // paymentRequiredPage: true, // 402 页面
    // paymentRequiredPage: {
    //     '/': 'custom-402.md'
    // },
    // 405 页面
    // methodNotAllowedPage: true, // 405 页面
    // methodNotAllowedPage: {
    //     '/': 'custom-405.md'
    // },
    // 406 页面
    // notAcceptablePage: true, // 406 页面
    // notAcceptablePage: {
    //     '/': 'custom-406.md'
    // },
    // 407 页面
    // proxyAuthenticationRequiredPage: true, // 407 页面
    // proxyAuthenticationRequiredPage: {
    //     '/': 'custom-407.md'
    // },
    // 408 页面
    // requestTimeoutPage: true, // 408 页面
    // requestTimeoutPage: {
    //     '/': 'custom-408.md'
    // },
    // 409 页面
    // conflictPage: true, // 409 页面
    // conflictPage: {
    //     '/': 'custom-409.md'
    // },
    // 410 页面
    // gonePage: true, // 410 页面
    // gonePage: {
    //     '/': 'custom-410.md'
    // },
    // 411 页面
    // lengthRequiredPage: true, // 411 页面
    // lengthRequiredPage: {
    //     '/': 'custom-411.md'
    // },
    // 412 页面
    // preconditionFailedPage: true, // 412 页面
    // preconditionFailedPage: {
    //     '/': 'custom-412.md'
    // },
    // 413 页面
    // payloadTooLargePage: true, // 413 页面
    // payloadTooLargePage: {
    //     '/': 'custom-413.md'
    // },
    // 414 页面
    // uriTooLongPage: true, // 414 页面
    // uriTooLongPage: {
    //     '/': 'custom-414.md'
    // },
    // 415 页面
    // unsupportedMediaTypePage: true, // 415 页面
    // unsupportedMediaTypePage: {
    //     '/': 'custom-415.md'
    // },
    // 416 页面
    // rangeNotSatisfiablePage: true, // 416 页面
    // rangeNotSatisfiablePage: {
    //     '/': 'custom-416.md'
    // },
    // 417 页面
    // expectationFailedPage: true, // 417 页面
    // expectationFailedPage: {
    //     '/': 'custom-417.md'
    // },
    // 418 页面
    // imATeapotPage: true, // 418 页面
    // imATeapotPage: {
    //     '/': 'custom-418.md'
    // },
    // 421 页面
    // misdirectedRequestPage: true, // 421 页面
    // misdirectedRequestPage: {
    //     '/': 'custom-421.md'
    // },
    // 422 页面
    // unprocessableEntityPage: true, // 422 页面
    // unprocessableEntityPage: {
    //     '/': 'custom-422.md'
    // },
    // 423 页面
    // lockedPage: true, // 423 页面
    // lockedPage: {
    //     '/': 'custom-423.md'
    // },
    // 424 页面
    // failedDependencyPage: true, // 424 页面
    // failedDependencyPage: {
    //     '/': 'custom-424.md'
    // },
    // 426 页面
    // upgradeRequiredPage: true, // 426 页面
    // upgradeRequiredPage: {
    //     '/': 'custom-426.md'
    // },
    // 428 页面
    // preconditionRequiredPage: true, // 428 页面
    // preconditionRequiredPage: {
    //     '/': 'custom-428.md'
    // },
    // 429 页面
    // tooManyRequestsPage: true, // 429 页面
    // tooManyRequestsPage: {
    //     '/': 'custom-429.md'
    // },
    // 431 页面
    // requestHeaderFieldsTooLargePage: true, // 431 页面
    // requestHeaderFieldsTooLargePage: {
    //     '/': 'custom-431.md'
    // },
    // 451 页面
    // unavailableForLegalReasonsPage: true, // 451 页面
    // unavailableForLegalReasonsPage: {
    //     '/': 'custom-451.md'
    // },
}
