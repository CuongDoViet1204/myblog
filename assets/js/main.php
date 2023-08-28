<script>

    function chooseSlidebar(slidebar) {
        var slidebarItems = document.querySelectorAll('.sliderbar__item')
        slidebar.classList.add('sliderbar__item-choose')
        for (var i = 0; i <  slidebarItems.length; i++) 
            if (slidebarItems[i] != slidebar) {
                slidebarItems[i].classList.remove('sliderbar__item-choose')
            } else {
                if (i == 0) {
                    showContentSearch()
                } else if (i == 1) {
                    showContentRead()
                } else if (i == 2) {    
                    var container = document.querySelector('.container')
                    container.innerHTML = ''
                    var xhttp = new XMLHttpRequest();
                    xhttp.open("GET", "database/getPostNumber.php", true);
                    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            var data = this.responseText
                            console.log(data)
                            showContentDiscover(data)
                        }
                    }
                    xhttp.send();
                } else if (i == 3) {
                    showContentLikes()
                } else if (i == 5) {
                    var container = document.querySelector('.container')
                    container.innerHTML = ''
                    var xhttp = new XMLHttpRequest();
                    xhttp.open("GET", "database/getPostNumber.php", true);
                    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            var data = this.responseText
                            console.log(data)
                            showContentMyPost(data)
                        }
                    }
                    xhttp.send();
                }
            }
    }

    function showContentMyPost(id) {
        if (id == 0) return
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var data = JSON.parse(this.responseText); // Dữ liệu trả về từ server
                console.log('data = ', data); // Hiển thị dữ liệu trong console

                var userId = ''

                <?php 
                    echo 'userId = \'' . $_SESSION['user']['id_email'] . '\'';
                ?>

                if (data != false && data['id_email'] == userId) {
                    var xhttp1 = new XMLHttpRequest();
                    xhttp1.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            var dataUser = JSON.parse(this.responseText)
                            var postList = document.querySelector('.post__list')
                            if (postList == null) {
                                var container = document.querySelector('.container')
                                container.innerHTML = ''
                                postList = document.createElement('div')
                                postList.classList.add('post__list')
                                container.appendChild(postList)
                            }
                            var postItem = document.createElement('div')
                            postItem.classList.add('post__item')
                            postItem.setAttribute('data-postId', data[0])
                            postItem.innerHTML = `
                                <div class="post__item-subject">
                                    ${data[2].replace(/^\n+/, '').replaceAll('\n', '<br>')}
                                </div>
                                <div class="post__item-info">
                                    <div class="post__item-info-author">@${dataUser['username']} - </div>
                                    <div class="post__item-info-create">${data[10]}</div>
                                </div>
                                <div class="post__item-body">
                                    <div class="post__item-body-text">
                                        ${data[3].replace(/^\n+/, '').replaceAll('\n', '<br>')}
                                    </div>
                                    <img src="${data[8]}" alt="" class="post__item-body-img">
                                </div>
                                <div class="post__item-footer">
                                    <div class="post__item-comment">
                                        <i class="post__item-icon-comment fa-regular fa-comments"></i>
                                        ${data[7]}
                                    </div>
                                    <div class="post__item-like">
                                        <i class="fa-regular fa-star post__item-icon-like"></i>
                                        ${data[6]}
                                    </div>
                                </div>
                            `
                            postItem.onclick = function() {
                                var xhttp2 = new XMLHttpRequest();
                                xhttp2.onreadystatechange = function() {
                                    if (this.readyState == 4 && this.status == 200) {
                                        var data = JSON.parse(this.responseText); // Dữ liệu trả về từ server

                                        var xhttp3 = new XMLHttpRequest();
                                        xhttp3.onreadystatechange = function() {
                                            if (this.readyState == 4 && this.status == 200) {
                                                var dataUser = JSON.parse(this.responseText)
                                                var myBlog = document.querySelector('.my__blog')
                                                var homePage = document.querySelector('.home__page')
                                                var personalInfo = document.querySelector('.personal__info')
                                                var container = document.querySelector('.container')
                                                var slidebar = document.querySelector('.slidebar')
                                                homePage.classList.remove('header__choose')
                                                myBlog.classList.remove('header__choose')
                                                personalInfo.classList.remove('header__choose')
                                                slidebar.style.display = 'none'
                                                container.style.paddingLeft = 0
                                                container.innerHTML = `
                                                    <div class="show__post">
                                                        <div class="container__sliderbar">
                                                            <div class="back__button" onclick="showHomePage()">
                                                                <i class="back__button-icon fa-solid fa-arrow-left"></i>
                                                                Trở lại
                                                            </div>
                                                            <div class="user__info">
                                                                <div class="user__info-img">
                                                                    <img src="${dataUser['avatar']}" alt="" class="user__info-img1">
                                                                    <img src="${dataUser['avatar']}" alt="" class="user__info-img2">
                                                                </div>
                                                                <div class="user__info-fullname">
                                                                    ${dataUser['fullname'] == null ? '' : dataUser['fullname']}
                                                                </div>
                                                                <div class="user__info-username">
                                                                    @${dataUser['username']}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="container__post">
                                                            <div class="container__post-title">
                                                                ${data['format_subject']}
                                                            </div>
        
                                                            <div class="container__post-time" style="color: #646970; font-size: 18px; margin: 10px 0 0 15px;">
                                                                ${data['created_at']}
                                                            </div>
        
                                                            <div class="container__post-content" style="margin-top: 40px;">
                                                                ${data['format_content']}
                                                            </div>
                                                        </div>
                                                    </div>
                                                `
                                                var containerPostTitle = document.querySelector('.container__post-title')
                                                var containerPostContent = document.querySelector('.container__post-content')
                                                var qlTooltip1 = document.querySelector('.container__post-title .ql-tooltip.ql-hidden')
                                                var qlTooltip2 = document.querySelector('.container__post-content .ql-tooltip.ql-hidden')
                                                containerPostTitle.removeChild(qlTooltip1)
                                                containerPostContent.removeChild(qlTooltip2)
                                                getCommentNumber(data['post_id'], 1)
                                            }
                                        }
                                        xhttp3.open("POST", "database/getInfoUser.php", true);
                                        xhttp3.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                                        xhttp3.send("data=" + encodeURIComponent(data[1]));
                                    }
                                }
                                xhttp2.open("POST", "database/getDataAllPosts.php", true);
                                xhttp2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                                xhttp2.send("data=" + encodeURIComponent(postItem.getAttribute('data-postId')));
                            }
                            postList.appendChild(postItem)
                        }
                    }
                    xhttp1.open("POST", "database/getInfoUser.php", true);
                    xhttp1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhttp1.send("data=" + encodeURIComponent(data[1]));
                    
                }
                showContentMyPost(id - 1)
            }
        };
        xhttp.open("POST", "database/getDataAllPosts.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("data=" + encodeURIComponent(id));
    }

    function showContentDiscover(id) {
        if (id == 0) return
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var data = JSON.parse(this.responseText); // Dữ liệu trả về từ server
                console.log('data = ', data); // Hiển thị dữ liệu trong console
                if (data != false) {
                    var xhttp1 = new XMLHttpRequest();
                    xhttp1.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            var dataUser = JSON.parse(this.responseText)
                            var postList = document.querySelector('.post__list')
                            if (postList == null) {
                                var container = document.querySelector('.container')
                                container.innerHTML = ''
                                postList = document.createElement('div')
                                postList.classList.add('post__list')
                                container.appendChild(postList)
                            }
                            var postItem = document.createElement('div')
                            postItem.classList.add('post__item')
                            postItem.setAttribute('data-postId', data[0])
                            postItem.innerHTML = `
                                <div class="post__item-subject">
                                    ${data[2].replace(/^\n+/, '').replaceAll('\n', '<br>')}
                                </div>
                                <div class="post__item-info">
                                    <div class="post__item-info-author">@${dataUser['username']} - </div>
                                    <div class="post__item-info-create">${data[10]}</div>
                                </div>
                                <div class="post__item-body">
                                    <div class="post__item-body-text">
                                        ${data[3].replace(/^\n+/, '').replaceAll('\n', '<br>')}
                                    </div>
                                    <img src="${data[8]}" alt="" class="post__item-body-img">
                                </div>
                                <div class="post__item-footer">
                                    <div class="post__item-comment">
                                        <i class="post__item-icon-comment fa-regular fa-comments"></i>
                                        ${data[7]}
                                    </div>
                                    <div class="post__item-like">
                                        <i class="fa-regular fa-star post__item-icon-like"></i>
                                        ${data[6]}
                                    </div>
                                </div>
                            `
                            postItem.onclick = function() {
                                var xhttp2 = new XMLHttpRequest();
                                xhttp2.onreadystatechange = function() {
                                    if (this.readyState == 4 && this.status == 200) {
                                        var data = JSON.parse(this.responseText); // Dữ liệu trả về từ server

                                        var xhttp3 = new XMLHttpRequest();
                                        xhttp3.onreadystatechange = function() {
                                            if (this.readyState == 4 && this.status == 200) {
                                                var dataUser = JSON.parse(this.responseText)
                                                var myBlog = document.querySelector('.my__blog')
                                                var homePage = document.querySelector('.home__page')
                                                var personalInfo = document.querySelector('.personal__info')
                                                var container = document.querySelector('.container')
                                                var slidebar = document.querySelector('.slidebar')
                                                homePage.classList.remove('header__choose')
                                                myBlog.classList.remove('header__choose')
                                                personalInfo.classList.remove('header__choose')
                                                slidebar.style.display = 'none'
                                                container.style.paddingLeft = 0
                                                container.innerHTML = `
                                                    <div class="show__post">
                                                        <div class="container__sliderbar">
                                                            <div class="back__button" onclick="showHomePage()">
                                                                <i class="back__button-icon fa-solid fa-arrow-left"></i>
                                                                Trở lại
                                                            </div>
                                                            <div class="user__info">
                                                                <div class="user__info-img">
                                                                    <img src="${dataUser['avatar']}" alt="" class="user__info-img1">
                                                                    <img src="${dataUser['avatar']}" alt="" class="user__info-img2">
                                                                </div>
                                                                <div class="user__info-fullname">
                                                                    ${dataUser['fullname'] == null ? '' : dataUser['fullname']}
                                                                </div>
                                                                <div class="user__info-username">
                                                                    @${dataUser['username']}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="container__post">
                                                            <div class="container__post-title">
                                                                ${data['format_subject']}
                                                            </div>
        
                                                            <div class="container__post-time" style="color: #646970; font-size: 18px; margin: 10px 0 0 15px;">
                                                                ${data['created_at']}
                                                            </div>
        
                                                            <div class="container__post-content" style="margin-top: 40px;">
                                                                ${data['format_content']}
                                                            </div>
                                                        </div>
                                                    </div>
                                                `
                                                var containerPostTitle = document.querySelector('.container__post-title')
                                                var containerPostContent = document.querySelector('.container__post-content')
                                                var qlTooltip1 = document.querySelector('.container__post-title .ql-tooltip.ql-hidden')
                                                var qlTooltip2 = document.querySelector('.container__post-content .ql-tooltip.ql-hidden')
                                                var qlEditor1 = document.querySelector('.container__post-title .ql-editor')
                                                var qlEditor2 = document.querySelector('.container__post-content .ql-editor')
                                                containerPostTitle.removeChild(qlTooltip1)
                                                containerPostContent.removeChild(qlTooltip2)
                                                qlEditor1.setAttribute('contenteditable', false)
                                                qlEditor2.setAttribute('contenteditable', false)
                                                getCommentNumber(data['post_id'])
                                            }
                                        }
                                        xhttp3.open("POST", "database/getInfoUser.php", true);
                                        xhttp3.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                                        xhttp3.send("data=" + encodeURIComponent(data[1]));
                                    }
                                }
                                xhttp2.open("POST", "database/getDataAllPosts.php", true);
                                xhttp2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                                xhttp2.send("data=" + encodeURIComponent(postItem.getAttribute('data-postId')));
                            }
                            postList.appendChild(postItem)
                        }
                    }
                    xhttp1.open("POST", "database/getInfoUser.php", true);
                    xhttp1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhttp1.send("data=" + encodeURIComponent(data[1]));
                    
                }
                showContentDiscover(id - 1)
            }
        };
        xhttp.open("POST", "database/getDataAllPosts.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("data=" + encodeURIComponent(id));
    }

    function getCommentNumber(postId, myPost = 0) {
        var containerPost = document.querySelector('.container__post')
        var commentPostComment = document.createElement('div')
        commentPostComment.classList.add('container__post-comment')
        commentPostComment.setAttribute('data-postId', postId)
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var data = this.responseText
                if (data == 0) {
                    commentPostComment.innerHTML = `
                        <div class="comment__number">${data} BÌNH LUẬN</div>
                        <div class="comment__input-form">
                            <label for="comment__input" class="comment__input-label">
                                <?php 
                                echo '<img src="' . $_SESSION['user']['avatar'] .'" alt="" class="comment__input-img">'
                                ?>
                            </label>
                            <input type="text" class="comment__input" name="comment__input" placeholder="Bình luận về bài viết này...">
                            <input type="submit" value="Gửi" class="comment__input-submit" name="comment__input-submit" onclick="postComment(this)">
                        </div>
                    `
                } else {
                    commentPostComment.innerHTML = `
                        <div class="comment__number">${data} BÌNH LUẬN</div>
                        <div class="comment__list"></div>
                        <div class="comment__input-form">
                            <label for="comment__input" class="comment__input-label">
                                <?php 
                                echo '<img src="' . $_SESSION['user']['avatar'] .'" alt="" class="comment__input-img">'
                                ?>
                            </label>
                            <input type="text" class="comment__input" name="comment__input" placeholder="Bình luận về bài viết này...">
                            <input type="submit" value="Gửi" class="comment__input-submit" name="comment__input-submit" onclick="postComment(this)">
                        </div>
                    `
                    var xhttp1 = new XMLHttpRequest();
                    xhttp1.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            var listPost = JSON.parse(this.responseText);
                            var commentList = document.querySelector('.comment__list')
                            for (var i = listPost.length - 1; i >= 0; i--) {
                                var xhttp2 = new XMLHttpRequest();
                                xhttp2.onreadystatechange = function() {
                                    if (this.readyState == 4 && this.status == 200) {
                                        var dataUser = JSON.parse(this.responseText);
                                        var commentItem = document.createElement('div')
                                        commentItem.classList.add('comment__item')
                                        commentItem.setAttribute('data-commentId', listPost[i]['comment_id'])
                                        if (myPost == 1) {
                                            commentItem.innerHTML = `
                                                <div class="comment__info">
                                                    <img src="${dataUser['avatar']}" alt="" class="comment__info-img">
                                                    <div class="comment__info-username">@${dataUser['username']}</div>
                                                    <div class="comment__info-created">&nbsp;- ${listPost[i]['created_at']}</div>
                                                </div>
                                                <div class="comment__content">
                                                    ${listPost[i]['comment_content']}
                                                </div>
                                                <div class="comment__delete" onclick="deleteComment(this)">
                                                    <i class="fa-solid fa-trash"></i>
                                                </div>
                                            `
                                        } else {
                                            commentItem.innerHTML = `
                                                <div class="comment__info">
                                                    <img src="${dataUser['avatar']}" alt="" class="comment__info-img">
                                                    <div class="comment__info-username">@${dataUser['username']}</div>
                                                    <div class="comment__info-created">&nbsp;- ${listPost[i]['created_at']}</div>
                                                </div>
                                                <div class="comment__content">
                                                    ${listPost[i]['comment_content']}
                                                </div>
                                            `
                                        }
                                        commentList.appendChild(commentItem)
                                    }
                                }
                                xhttp2.open("POST", "database/getInfoUser.php", false);
                                xhttp2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                                xhttp2.send("data=" + encodeURIComponent(listPost[i]['id_email']));
                            }
                        }
                    }
                    xhttp1.open("POST", "database/getListComment.php", true);
                    xhttp1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhttp1.send("data=" + encodeURIComponent(postId));
                }
                containerPost.appendChild(commentPostComment)
            }
        }
        xhttp.open("POST", "database/getCommentNumber.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("data=" + encodeURIComponent(postId));
    }

    function deleteComment(deleteButton) {
        var commentPostComment = deleteButton.parentNode.parentNode.parentNode
        var commentItem = deleteButton.parentNode
        var cmtId = commentItem.getAttribute('data-commentId')
        console.log(cmtId)
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var containerPost = document.querySelector('.container__post')
                containerPost.removeChild(commentPostComment)
                getCommentNumber(commentPostComment.getAttribute('data-postId'), 1)
            }
        }
        xhttp.open("POST", "database/deleteComment.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("data=" + encodeURIComponent(cmtId));
    }

    function postComment(submit) {
        var commentPostComment = submit.parentNode.parentNode
        var postId = commentPostComment.getAttribute('data-postId')
        var content = submit.parentNode.children[1].value
        // var idUser
        if (content == '') {
            alert('Bạn chưa bình luận!')
            return
        }
        var data = []

        <?php 
            echo 'data.push(\''. $_SESSION['user']['id_email'] . '\')';
        ?>

        data.push(parseInt(postId))
        data.push(content)

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var containerPost = document.querySelector('.container__post')
                containerPost.removeChild(commentPostComment)
                getCommentNumber(postId)
            }
        }
        xhttp.open("POST", "database/postComment.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("data=" + encodeURIComponent(JSON.stringify(data)));
    }
    
    function chooseHeader(headerItem) {
        var myBlog = document.querySelector('.my__blog')
        var homePage = document.querySelector('.home__page')
        var personalInfo = document.querySelector('.personal__info')
        var createPost = document.querySelector('.create__post')
        if (headerItem == myBlog) {
            showMyBlog()
        } else if (headerItem == homePage) {
            showHomePage()
        } else if (headerItem == personalInfo) {
            showPersonalInfo()
        } else {
            showCreatePost()
        }
    }
    
    function showMyBlog() {
        var myBlog = document.querySelector('.my__blog')
        var homePage = document.querySelector('.home__page')
        var personalInfo = document.querySelector('.personal__info')
        var container = document.querySelector('.container')
        var slidebar = document.querySelector('.slidebar')
        homePage.classList.remove('header__choose')
        myBlog.classList.add('header__choose')
        personalInfo.classList.remove('header__choose')
        slidebar.style.display = 'none'
        container.style.paddingLeft = 0
        container.innerHTML = `
            <div class="notification__no-result">
                <img src="./assets/img/illustration-nosites.svg" alt="" class="no-result__img">
                <div class="no__result-title">Bạn chưa có một trang WordPress nào.</div>
                <div class="no__result-description">Bạn có muốn tạo một trang cho riêng mình?</div>
            </div>
        `
    }

    function showCreatePost() {
        var myBlog = document.querySelector('.my__blog')
        var homePage = document.querySelector('.home__page')
        var personalInfo = document.querySelector('.personal__info')
        var container = document.querySelector('.container')
        var slidebar = document.querySelector('.slidebar')
        homePage.classList.remove('header__choose')
        myBlog.classList.remove('header__choose')
        personalInfo.classList.remove('header__choose')
        slidebar.style.display = 'none'
        container.style.paddingLeft = 0
        container.innerHTML = `
            <div class="create__post-editor">
                <div id="toolbar-container1">
                    <span class="ql-formats">
                        <button class="ql-bold"></button>
                        <button class="ql-italic"></button>
                        <button class="ql-underline"></button>
                        <button class="ql-strike"></button>
                    </span>

                    <span class="ql-formats">
                        <select class="ql-header">
                            <option value="1"></option>
                            <option value="2"></option>
                            <option value="3"></option>
                            <option value="4"></option>
                            <option value="5"></option>
                            <option value="6"></option>
                            <option selected></option>
                        </select>
                    </span>

                    <span class="ql-formats">
                        <button type="button" class="ql-list" value="ordered"></button>
                        <button type="button" class="ql-list" value="bullet"></button>
                    </span>

                    <span class="ql-formats">
                        <button type="button" class="ql-script" value="sub"></button>
                        <button type="button" class="ql-script" value="super"></button>
                    </span>
                    <span class="ql-formats">
                        <button type="button" class="ql-indent" value="+1"></button>
                        <button type="button" class="ql-indent" value="-1"></button>
                    </span>

                    <span class="ql-formats">
                        <select class="ql-align">
                            <option selected></option>
                            <option value="center"></option>
                            <option value="right"></option>
                            <option value="justify"></option>
                        </select>
                    </span>
                    <span class="ql-formats">
                        <select class="ql-size">
                            <option value="8px">8</option>
                            <option value="9px">9</option>
                            <option value="10px">10</option>
                            <option selected value="11px">11</option>
                            <option value="12px">12</option>
                            <option value="14px">14</option>
                            <option value="16px">16</option>
                            <option value="18px">18</option>
                            <option value="20px">20</option>
                            <option value="22px">22</option>
                            <option value="24px">24</option>
                            <option value="26px">26</option>
                            <option value="28px">28</option>
                            <option value="30px">30</option>
                            <option value="32px">32</option>
                        </select>
                    </span>
                    <span class="ql-formats">
                        <button type="button" class="ql-image"></button>
                        <button type="button" class="ql-link"></button>
                        <button type="button" class="ql-video"></button>
                    </span>
                    <span class="ql-formats">
                        <select class="ql-color">
                            <option selected="selected"></option>
                            <option value="#e60000"></option>
                            <option value="#ff9900"></option>
                            <option value="#ffff00"></option>
                            <option value="#008a00"></option>
                            <option value="#0066cc"></option>
                            <option value="#9933ff"></option>
                            <option value="#ffffff"></option>
                            <option value="#facccc"></option>
                            <option value="#ffebcc"></option>
                            <option value="#ffffcc"></option>
                            <option value="#cce8cc"></option>
                            <option value="#cce0f5"></option>
                            <option value="#ebd6ff"></option>
                            <option value="#bbbbbb"></option>
                            <option value="#f06666"></option>
                            <option value="#ffc266"></option>
                            <option value="#ffff66"></option>
                            <option value="#66b966"></option>
                            <option value="#66a3e0"></option>
                            <option value="#c285ff"></option>
                            <option value="#888888"></option>
                            <option value="#a10000"></option>
                            <option value="#b26b00"></option>
                            <option value="#b2b200"></option>
                            <option value="#006100"></option>
                            <option value="#0047b2"></option>
                            <option value="#6b24b2"></option>
                            <option value="#444444"></option>
                            <option value="#5c0000"></option>
                            <option value="#663d00"></option>
                            <option value="#666600"></option>
                            <option value="#003700"></option>
                            <option value="#002966"></option>
                            <option value="#3d1466"></option></select>
                        <select class="ql-background">
                            <option value="#000000"></option>
                            <option value="#e60000"></option>
                            <option value="#ff9900"></option>
                            <option value="#ffff00"></option>
                            <option value="#008a00"></option>
                            <option value="#0066cc"></option>
                            <option value="#9933ff"></option>
                            <option selected="selected"></option>
                            <option value="#facccc"></option>
                            <option value="#ffebcc"></option>
                            <option value="#ffffcc"></option>
                            <option value="#cce8cc"></option>
                            <option value="#cce0f5"></option>
                            <option value="#ebd6ff"></option>
                            <option value="#bbbbbb"></option>
                            <option value="#f06666"></option>
                            <option value="#ffc266"></option>
                            <option value="#ffff66"></option>
                            <option value="#66b966"></option>
                            <option value="#66a3e0"></option>
                            <option value="#c285ff"></option>
                            <option value="#888888"></option>
                            <option value="#a10000"></option>
                            <option value="#b26b00"></option>
                            <option value="#b2b200"></option>
                            <option value="#006100"></option>
                            <option value="#0047b2"></option>
                            <option value="#6b24b2"></option>
                            <option value="#444444"></option>
                            <option value="#5c0000"></option>
                            <option value="#663d00"></option>
                            <option value="#666600"></option>
                            <option value="#003700"></option>
                            <option value="#002966"></option>
                            <option value="#3d1466"></option>
                        </select>
                    </span>
                    <span class="ql-formats">
                        <select class="ql-font">
                            <option selected value="san-serif"></option>
                            <option value="serif"></option>
                            <option value="monospace"></option>
                            <option value="roboto">Roboto</option>
                            <option value="arial">Arial</option>
                            <option value="tnr">Times NR</option>
                            <option value="courierNew">Courier New</option>
                            <option value="fgm">Franklin GM</option>
                            <option value="gillSans">Gill Sans</option>
                            <option value="lucidaSans">Lucida Sans</option>
                            <option value="segoeUI">Segoe UI</option>
                            <option value="trebuchetMS">Trebuchet MS</option>
                            <option value="cambria">Cambria</option>
                        </select>
                    </span>
                </div>
                <div id="subject"></div>
                <div id="toolbar-container2">
                    <span class="ql-formats">
                        <button class="ql-bold"></button>
                        <button class="ql-italic"></button>
                        <button class="ql-underline"></button>
                        <button class="ql-strike"></button>
                    </span>

                    <span class="ql-formats">
                        <select class="ql-header">
                            <option value="1"></option>
                            <option value="2"></option>
                            <option value="3"></option>
                            <option value="4"></option>
                            <option value="5"></option>
                            <option value="6"></option>
                            <option selected></option>
                        </select>
                    </span>

                    <span class="ql-formats">
                        <button type="button" class="ql-list" value="ordered"></button>
                        <button type="button" class="ql-list" value="bullet"></button>
                    </span>

                    <span class="ql-formats">
                        <button type="button" class="ql-script" value="sub"></button>
                        <button type="button" class="ql-script" value="super"></button>
                    </span>
                    <span class="ql-formats">
                        <button type="button" class="ql-indent" value="+1"></button>
                        <button type="button" class="ql-indent" value="-1"></button>
                    </span>

                    <span class="ql-formats">
                        <select class="ql-align">
                            <option selected></option>
                            <option value="center"></option>
                            <option value="right"></option>
                            <option value="justify"></option>
                        </select>
                    </span>
                    <span class="ql-formats">
                        <select class="ql-size">
                            <option value="8px">8</option>
                            <option value="9px">9</option>
                            <option value="10px">10</option>
                            <option selected value="11px">11</option>
                            <option value="12px">12</option>
                            <option value="14px">14</option>
                            <option value="16px">16</option>
                            <option value="18px">18</option>
                            <option value="20px">20</option>
                            <option value="22px">22</option>
                            <option value="24px">24</option>
                            <option value="26px">26</option>
                            <option value="28px">28</option>
                            <option value="30px">30</option>
                            <option value="32px">32</option>
                        </select>
                    </span>
                    <span class="ql-formats">
                        <button type="button" class="ql-image"></button>
                        <button type="button" class="ql-link"></button>
                        <button type="button" class="ql-video"></button>
                    </span>
                    <span class="ql-formats">
                        <select class="ql-color">
                            <option selected="selected"></option>
                            <option value="#e60000"></option>
                            <option value="#ff9900"></option>
                            <option value="#ffff00"></option>
                            <option value="#008a00"></option>
                            <option value="#0066cc"></option>
                            <option value="#9933ff"></option>
                            <option value="#ffffff"></option>
                            <option value="#facccc"></option>
                            <option value="#ffebcc"></option>
                            <option value="#ffffcc"></option>
                            <option value="#cce8cc"></option>
                            <option value="#cce0f5"></option>
                            <option value="#ebd6ff"></option>
                            <option value="#bbbbbb"></option>
                            <option value="#f06666"></option>
                            <option value="#ffc266"></option>
                            <option value="#ffff66"></option>
                            <option value="#66b966"></option>
                            <option value="#66a3e0"></option>
                            <option value="#c285ff"></option>
                            <option value="#888888"></option>
                            <option value="#a10000"></option>
                            <option value="#b26b00"></option>
                            <option value="#b2b200"></option>
                            <option value="#006100"></option>
                            <option value="#0047b2"></option>
                            <option value="#6b24b2"></option>
                            <option value="#444444"></option>
                            <option value="#5c0000"></option>
                            <option value="#663d00"></option>
                            <option value="#666600"></option>
                            <option value="#003700"></option>
                            <option value="#002966"></option>
                            <option value="#3d1466"></option></select>
                        <select class="ql-background">
                            <option value="#000000"></option>
                            <option value="#e60000"></option>
                            <option value="#ff9900"></option>
                            <option value="#ffff00"></option>
                            <option value="#008a00"></option>
                            <option value="#0066cc"></option>
                            <option value="#9933ff"></option>
                            <option selected="selected"></option>
                            <option value="#facccc"></option>
                            <option value="#ffebcc"></option>
                            <option value="#ffffcc"></option>
                            <option value="#cce8cc"></option>
                            <option value="#cce0f5"></option>
                            <option value="#ebd6ff"></option>
                            <option value="#bbbbbb"></option>
                            <option value="#f06666"></option>
                            <option value="#ffc266"></option>
                            <option value="#ffff66"></option>
                            <option value="#66b966"></option>
                            <option value="#66a3e0"></option>
                            <option value="#c285ff"></option>
                            <option value="#888888"></option>
                            <option value="#a10000"></option>
                            <option value="#b26b00"></option>
                            <option value="#b2b200"></option>
                            <option value="#006100"></option>
                            <option value="#0047b2"></option>
                            <option value="#6b24b2"></option>
                            <option value="#444444"></option>
                            <option value="#5c0000"></option>
                            <option value="#663d00"></option>
                            <option value="#666600"></option>
                            <option value="#003700"></option>
                            <option value="#002966"></option>
                            <option value="#3d1466"></option>
                        </select>
                    </span>
                    <span class="ql-formats">
                        <select class="ql-font">
                            <option selected value="san-serif"></option>
                            <option value="serif"></option>
                            <option value="monospace"></option>
                            <option value="roboto">Roboto</option>
                            <option value="arial">Arial</option>
                            <option value="tnr">Times NR</option>
                            <option value="courierNew">Courier New</option>
                            <option value="fgm">Franklin GM</option>
                            <option value="gillSans">Gill Sans</option>
                            <option value="lucidaSans">Lucida Sans</option>
                            <option value="segoeUI">Segoe UI</option>
                            <option value="trebuchetMS">Trebuchet MS</option>
                            <option value="cambria">Cambria</option>
                        </select>
                    </span>
                </div>
                <div id="editor"></div>
                <div class="submit__new-post" onclick="saveNewPost()">Tạo</div>
            </div>
        `
        var SizeStyle = Quill.import('attributors/style/size');
        SizeStyle.whitelist = [
            '8px', '9px', '10px', '11px', '12px', '14px', '16px', '18px', '20px', '22px', '24px', '26px', '28px', '30px', '32px'
        ];
        Quill.register(SizeStyle, true);

        var FontAttributor = Quill.import('attributors/class/font');
        FontAttributor.whitelist = [
            'roboto', 'arial', 'tnr', 'courierNew', 'fgm', 'gillSans', 'lucidaSans', 'segoeUI', 'trebuchetMS', 'cambria', 'serif', 'monospace', 'san-serif'
        ];
        Quill.register(FontAttributor, true);
        quill = new Quill('#editor', {
            modules: {
                toolbar: '#toolbar-container2'
            },
            theme: 'snow',
            spellCheck: false
        });

        quillsj = new Quill('#subject', {
            modules: {
                toolbar: '#toolbar-container1'
            },
            theme: 'snow',
            spellCheck: false
        });
            // Initialize as you would normally
            
    }

    function saveNewPost() {
        var subject = document.querySelector('#subject').innerHTML;
        var body = document.querySelector('#editor').innerHTML;
        var dataBodys = quill.getContents()['ops']
        var dataSubject = quillsj.getContents()['ops'][0]['insert']
        var dataBody = ''
        var img = ''
        for (var i = 0; i < dataBodys.length; i++) {
            if (dataBodys[i]['insert']['image'] == null) {
                dataBody += dataBodys[i]['insert']
            }
        }
        for (var i = 0; i < dataBodys.length; i++) {
            if (dataBodys[i]['insert']['image'] != null) {
                img = dataBodys[i]['insert']['image']
                break
            }
        }
        if (dataSubject == '\n' || dataBody == '\n') {
            alert('Tạo bài viết mới thất bại!')
            return
        }
        var data = []
        data.push(dataSubject)
        data.push(dataBody)
        data.push(subject)
        data.push(body)
        data.push(img)
        console.log(data)
        // Gửi dữ liệu bằng AJAX
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // cntLoadPost++
                showHomePage()
            }
        };
        xhttp.open("POST", "database/processDataPost.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("data=" + encodeURIComponent(JSON.stringify(data)));
    }

    function chooseSlidebarInfoUser(slidebar) {
        var slidebarItems = document.querySelectorAll('.sliderbar__item')
        slidebar.classList.add('sliderbar__item-choose')
        for (var i = 0; i <  slidebarItems.length; i++) 
            if (slidebarItems[i] != slidebar) {
                slidebarItems[i].classList.remove('sliderbar__item-choose')
            } else {
                if (i == 0) {
                    showContentPersonalInfo()
                } else if (i == 1) {
                    showContentSettingAccount()
                } 
            }
    }

    function showContentPersonalInfo() {
        var container = document.querySelector('.container')
        container.innerHTML = `
            <div class="show__personal-info">
                <div class="personal__info-title">Thông tin của tôi</div>
                <div class="personal__info-title-2">Hồ sơ</div>
                <div class="personal__info-body">
                    <?php 
                    echo '<img src="' . $_SESSION['user']['avatar'] . '" alt="" class="personal__info-body-img">
                        <div class="personal__info-body-info">
                            <div class="personal__info-body-fullname">
                                <p class="personal__info-body-label">Tên hiển thị công khai:</p>'
                                . $_SESSION['user']['fullname'] .
                            '</div>
                            <div class="personal__info-body-username">
                                <p class="personal__info-body-label">Tên người dùng:</p>'
                                . $_SESSION['user']['username'] .
                            '</div>
                            <div class="personal__info-body-email">
                                <p class="personal__info-body-label">Email:</p>'  
                                . $_SESSION['user']['gmail'] .
                            '</div>
                        </div>';
                    ?>
                    
                </div>
            </div>
        `
    }

    function showContentSettingAccount() {
        var container = document.querySelector('.container')
        container.innerHTML = `
            <div class="show__setting-account">
                <div class="setting__account-title">Cài đặt tài khoản</div>
                <div class="setting__account-item">
                    <div class="setting__account-title-2">Thông tin tài khoản</div>
                    <form action="index.php" method="POST" class="setting__account-form">
                        <div class="setting__account-body">
                            <?php 
                                echo '<img src="' . $_SESSION['user']['avatar'] . '" alt="" class="setting__account-body-img">
                                <div class="setting__account-body-info">
                                    <label for="setting-fullname" class="setting__account-body-label">Tên hiển thị công khai:</label>
                                    <br>
                                    <input type="text" class="setting__account-body-input" name="setting-fullname" id="setting-fullname" value="'. $_SESSION['user']['fullname'] .'">
                                    <br>
                                    <label for="setting-username" class="setting__account-body-label">Tên người dùng:</label>
                                    <br>
                                    <input type="text" class="setting__account-body-input" name="setting-username" id="setting-username" value="'. $_SESSION['user']['username'] .'">
                                </div>';
                            ?>
                        </div>
                        <input type="submit" value="Lưu" class="setting__account-submit" name="submit-setting-account">
                    </form>
                </div>
            </div>
        `
    }
    
    function showPersonalInfo() {
        var myBlog = document.querySelector('.my__blog')
        var homePage = document.querySelector('.home__page')
        var personalInfo = document.querySelector('.personal__info')
        var slidebar = document.querySelector('.slidebar')
        var container = document.querySelector('.container')
        personalInfo.classList.add('header__choose')
        myBlog.classList.remove('header__choose')
        homePage.classList.remove('header__choose')
        slidebar.style.display = 'block'
        container.style.paddingLeft = '272px'
        slidebar.innerHTML = `
            <div class="sliderbar__user-info">
                <?php
                echo '<img src="' . $_SESSION['user']['avatar'] . '" alt="" class="sliderbar__user-img">
                    <div class="sliderbar__user-name">' . $_SESSION['user']['fullname'] . '</div>
                    <div class="sliderbar__user-name-account">@' . $_SESSION['user']['username'] . '</div>';
                ?>
                <div class="btn-logout">Đăng xuất</div>
            </div>
            <div class="sliderbar__item sliderbar__item-user-info" onclick="chooseSlidebarInfoUser(this)">
                <div class="blank__div"></div>
                <i class="sliderbar__item-icon fa-regular fa-user"></i>
                Thông tin của tôi
            </div>
            <div class="sliderbar__item sliderbar__item-setting-account" onclick="chooseSlidebarInfoUser(this)">
                <div class="blank__div"></div>
                <i class="sliderbar__item-icon fa-solid fa-gear"></i>
                Cài đặt tài khoản
            </div>
        `
        var slidebarItems = document.querySelectorAll('.sliderbar__item')
        var slidebarItemUserInfo = document.querySelector('.sliderbar__item-user-info')
        for (var slidebarItem of slidebarItems) {
            if (slidebarItemUserInfo == slidebarItem) {
                slidebarItem.classList.add('sliderbar__item-choose')
            } else {
                slidebarItem.classList.remove('sliderbar__item-choose')
            }
        }
        showContentPersonalInfo()
    }
    
    function showHomePage() {
        var myBlog = document.querySelector('.my__blog')
        var homePage = document.querySelector('.home__page')
        var personalInfo = document.querySelector('.personal__info')
        var slidebar = document.querySelector('.slidebar')
        var container = document.querySelector('.container')
        homePage.classList.add('header__choose')
        myBlog.classList.remove('header__choose')
        personalInfo.classList.remove('header__choose')
        slidebar.style.display = 'block'
        container.style.paddingLeft = '272px'
        slidebar.innerHTML = `
            <div class="sliderbar__item sliderbar__item-search" onclick="chooseSlidebar(this)">
                <div class="blank__div"></div>
                <i class="sliderbar__item-icon fa-solid fa-magnifying-glass"></i>
                Tìm kiếm
            </div>
            <div class="sliderbar__item sliderbar__item-read" onclick="chooseSlidebar(this)">
                <div class="blank__div"></div>
                <i class="sliderbar__item-icon fa-solid fa-check"></i>
                Đang theo dõi
            </div>
            <div class="sliderbar__item sliderbar__item-discover" onclick="chooseSlidebar(this)">
                <div class="blank__div"></div>
                <i class="sliderbar__item-icon fa-sharp fa-regular fa-compass"></i>
                Khám phá
            </div>
            <div class="sliderbar__item sliderbar__item-likes" onclick="chooseSlidebar(this)">
                <div class="blank__div"></div>
                <i class="sliderbar__item-icon fa-regular fa-star"></i>
                Lượt thích
            </div>
            <div class="sliderbar__item sliderbar__item-notifications" onclick="chooseSlidebar(this)">
                <div class="blank__div"></div>
                <i class="sliderbar__item-icon fa-regular fa-bell"></i>
                Thông báo
            </div>
            <div class="sliderbar__item sliderbar__item-mypost" onclick="chooseSlidebar(this)">
                <div class="blank__div"></div>
                <i class="sliderbar__item-icon fa-regular fa-rectangle-list"></i>
                Bài viết của tôi
            </div>
        `
        var slidebarItems = document.querySelectorAll('.sliderbar__item')
        var slidebarItemRead = document.querySelector('.sliderbar__item-read')
        for (var slidebarItem of slidebarItems) {
            if (slidebarItemRead == slidebarItem) {
                slidebarItem.classList.add('sliderbar__item-choose')
            } else {
                slidebarItem.classList.remove('sliderbar__item-choose')
            }
        }
        showContentRead()
    }
    
    function showContentSearch() {
        var container = document.querySelector('.container')
        container.innerHTML = `
            <div class="search__bar">
                <i class="search__bar-icon fa-solid fa-magnifying-glass"></i>
                <input type="text" class="search__bar-input" placeholder="Search Reader">
            </div>
            <div class="notification__no-result">
                <img src="./assets/img/illustration-empty-results (1).svg" alt="" class="no-result__img">
                <div class="no__result-title">Không có kết quả</div>
                <div class="no__result-description">Không có bài viết nào trong ngôn ngữ của bạn.</div>
            </div>
        `
    }
    
    function showContentRead() {
        var container = document.querySelector('.container')
        container.innerHTML = `
            <div class="notification__no-result">
                <img src="./assets/img/reader-welcome-illustration-a5f745b60aa2abc94678.svg" alt="" class="no-result__img">
                <div class="no__result-title">Chào mừng tới Đọc</div>
                <div class="no__result-description">Bài viết mới từ các trang blog mà bạn theo dõi sẽ xuất hiện ở đây.</div>
            </div>
        `
    }
    
    function showContentLikes() {
        var container = document.querySelector('.container')
        container.innerHTML = `
            <div class="notification__no-result">
                <img src="./assets/img/illustration-empty-results.svg" alt="" class="no-result__img">
                <div class="no__result-title">No likes yet</div>
                <div class="no__result-description">Posts that you like will appear here.</div>
            </div>
        `
    }
    var quill, quillsj
    showHomePage()
    var gSlidebarItemRead = document.querySelector('.sliderbar__item-read')
    gSlidebarItemRead.classList.add('sliderbar__item-choose')
    showContentRead()
</script>

