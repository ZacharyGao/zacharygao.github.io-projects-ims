var defaultOptions = {
    headings: 'h1, h2, h3, h4',  // 根据需要包括 h3, h4 等
    scope: 'main',  // 修改为您想要包含目录的元素的选择器
    // scope: '.main',  // 修改为您想要包含目录的元素的选择器
    title: 'Table of Contents',
    listType: 'ul',
}

// 构建目录
var buildTOC = function (options) {
    var headers = document.querySelectorAll(options.scope + ' ' + options.headings);

    var toc = document.createElement(options.listType);
    toc.className = 'nav';  // 使用您的 CSS 类名

    var lastLevel = 0;
    var currentList = toc;

    // 遍历所有标题
    headers.forEach(function (header) {
        var level = parseInt(header.tagName.substring(1));

        var li = document.createElement('li');
        var a = document.createElement('a');
        a.href = '#' + header.id;
        a.textContent = header.textContent;
        li.appendChild(a);
        toc.appendChild(li);


        while (level > lastLevel) {
            var newList = document.createElement('ul');
            var newListItem = document.createElement('li');
            newListItem.appendChild(newList);
            currentList.appendChild(newListItem);
            currentList = newList;
            lastLevel++;
        }

        while (level < lastLevel) {
            currentList = currentList.parentNode.parentNode; // 向上移动到更高层级的列表
            lastLevel--;
        }

        currentList.appendChild(li);

    });

    return toc;
};


// function updateActiveLink() {
//     var sections = document.querySelectorAll("main h1, main h2, main h3, main h4");
//     var tocLinks = document.querySelectorAll(".page_toc a");

//     // console.log(sections);

//     var scrollPosition = document.documentElement.scrollTop || document.body.scrollTop;

//     sections.forEach(function (section) {
//         if (section.offsetTop <= scrollPosition && section.offsetTop + section.offsetHeight > scrollPosition) {
//             tocLinks.forEach(function (link) {
//                 link.parentElement.classList.remove('active');
//                 if (section.getAttribute('id') === decodeURIComponent(link.hash).substring(1)) {
//                     link.parentElement.classList.add('active');
//                     // console.log(link.parentElement);
//                 }
//             });
//         }
//     });
// }


var updateActiveLink = function() {
    var sections = document.querySelectorAll(defaultOptions.scope + ' ' + defaultOptions.headings);
    var tocLinks = document.querySelectorAll('.page_toc a');

    var scrollPosition = document.documentElement.scrollTop || document.body.scrollTop;

    sections.forEach(function(section) {
        var sectionTop = section.offsetTop;
        var sectionBottom = sectionTop + section.offsetHeight;
        if (scrollPosition >= sectionTop && scrollPosition < sectionBottom) {
            tocLinks.forEach(function(link) {
                link.parentElement.classList.remove('active');
                if (section.getAttribute('id') === link.getAttribute('href').substring(1)) {
                    link.parentElement.classList.add('active');
                }
            });
        }
    });
};


// 当文档加载完成后执行
document.addEventListener("DOMContentLoaded", function () {
    var toc = buildTOC(defaultOptions);
    var container = document.createElement('div');  // 使用 nav 代替 div
    container.className = 'page_toc';  // 使用您的 CSS 类名

    var title = document.createElement('h3');
    title.textContent = defaultOptions.title;
    container.appendChild(title);
    container.appendChild(toc);

    var contentArea = document.querySelector(defaultOptions.scope);
    if (contentArea) {
        contentArea.insertBefore(container, contentArea.firstChild);
    }

    // // 添加滚动效果
    // var links = document.querySelectorAll('.page_toc a');
    // links.forEach(function(link) {
    //     link.addEventListener('click', function(e) {
    //         e.preventDefault();
    //         var target = document.querySelector(this.getAttribute('href'));
    //         target.scrollIntoView({behavior: 'smooth'});
    //     });
    // });

    // // 添加滚动事件
    // var toc = document.querySelector('.page_toc');
    // var tocTop = toc.offsetTop;
    // var tocBottom = tocTop + toc.offsetHeight;
    // window.addEventListener('scroll', function(e) {
    //     var scrollPos = window.scrollY;
    //     if (scrollPos >= tocTop && scrollPos < tocBottom) {
    //         toc.classList.add('fixed');
    //     } else {
    //         toc.classList.remove('fixed');
    //     }
    // });

    // // 添加点击事件
    // var tocToggle = document.querySelector('.page_toc h3');
    // tocToggle.addEventListener('click', function(e) {
    //     e.preventDefault();
    //     toc.classList.toggle('open');
    // });


    // 添加关闭事件
    // var tocClose = document.querySelector('.page_toc .close');
    // tocClose.addEventListener('click', function(e) {
    //     e.preventDefault();
    //     toc.classList.remove('open');
    // });

    // active link
    window.addEventListener('scroll', function () {
        updateActiveLink();
    });

});
