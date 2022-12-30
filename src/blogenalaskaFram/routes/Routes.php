<?php

/* 
 * List of frontend routes
 */

/**
 * Route which get the posts from the main page of the blog
 */
$router->get('/', "Frontend#renderHomepage");

/**
 * Paginate posts
 */
$router->get('/articles:page', "Frontend#renderPaginatedposts");

/**
 * Frontend post
 */
$router->get('/article:id:page', "Frontend#renderPost");
$router->post('/article:id:page', "Frontend#renderPost");

/**
 * Route which goes to the post and to the comment which can be modify into the form
 */
$router->post('/article:id:idcomment', "Frontend#renderPost");

/**
 * Send email
 */
$router->post('/sendEmail', "Frontend#sendEmailToAuthor");

/**
 * Delete comment
 */
$router->post('/deletecomment:id:idcomment', "Frontend#deleteComment");

/**
 * Manage clicks for the unwanted comments
 */
$router->post('/unwantedcomments', "Frontend#unwantedComment");

/**
 * Get legal notices
 */
$router->get('/getlegalnotices', "Frontend#renderLegalNotices");


/* 
 * List of admin routes
 */

/**
 * Create author form
 */
$router->get('/createuser', "Author#createUser");
$router->post('/createuser', "Author#createUser");

/**
 * Disconnect user
 */
$router->post('/logout', "Author#logOut");

/**
 * Connect form user
 */
$router->get('/connectform', "Author#logUser");
$router->post('/connectform', "Author#logUser");

/**
 * Update user
 */
$router->get('/updateuser:id', "Author#updateUser");
$router->post('/updateuser:id', "Author#updateUser");

/**
 * Delete user
 */
$router->get('/deleteuser:id', "Author#deleteUser");

/**
 * upload user image
 */
$router->post('/authoruploadimage', "Author#uploadImage");


/* 
 * List of backend routes
 */

/**
 * Route which goes to the backend
 */
$router->get('/backoffice', "Backend#renderHomepage");

/**
 * Get posts into datables
 */
$router->post('/listofarticles', "Backend#getListOfArticles");

/**
 * Create posts
 */
$router->get('/createpost', "Backend#createPost");
$router->post('/createpost', "Backend#createPost");

/**
 * Upload image
 */
$router->post('/uploadimage', "Backend#uploadImage");

/**
 * Insert folder path
 */
$router->get('/iGetImageIntoFormFromUploadPath&data', "Backend#getImagePath");

/**
 * Update post
 */
$router->get('/updatepost:id', "Backend#updatePost");
$router->post('/updatepost:id', "Backend#updatePost");

/**
 * Delete post
 */
$router->post('/deletepost', "Backend#deletePost");

/**
 * Redirect user if the post has been well deleted
 */
$router->get('/confirmdeletepost', "Backend#confirmDeletedPost");

/**
 * Render page with comments
 */
$router->get('/rendercommentspage', "Backend#renderCommentsPage");

/**
 * Get comments into datatables
 */
$router->post('/listofcomments', "Backend#getListOfComments");

/**
 * Delete a comment into datatables
 */
$router->post('/deletecomment', "Backend#deleteComments");

/**
 * Redirect user after delete a comment into datatables
 */
$router->get('/confirmdeletecomment', "Backend#confirmDeletedComments");

/**
 * Search posts
 */
$router->post('/searchPosts', "Search#search");

/**
 * Page 404
 */
$router->get('/page404', "Render#renderPage404");