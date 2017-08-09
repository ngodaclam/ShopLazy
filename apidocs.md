FORMAT: 1A

# Candy-CMS

# Client [/client]

## Get access token [POST /client/access_token]
Get a JSON representation of access token by client id and secret, if grant type is password, email (username)
and password is required.

+ Parameters
    + grant_type (string, required) - Grant type by 'password' or 'client_credentials'
    + client_id (string, required) - Registered client id
    + client_secret (string, required) - Registered client secret
    + username (string, optional) - Username required if grant type is 'password'
    + password (string, optional) - Password required if grant type is 'password'

+ Request Grant by 'client_credentials' (application/json)
    + Body

            {
                "grant_type": "client_credentials",
                "client_id": "VmUXPLVP4oTsk2jY",
                "client_secret": "UgozNlpaCQ5wtjtnIJkst6j6pCRPyGys"
            }

+ Request Grant by 'password' (application/json)
    + Body

            {
                "grant_type": "password",
                "client_id": "VmUXPLVP4oTsk2jY",
                "client_secret": "UgozNlpaCQ5wtjtnIJkst6j6pCRPyGys",
                "username": "user01@local.app",
                "password": "secret"
            }

+ Response 200 (application/json)
    + Body

            {
                "access_token": "MMg6nTjWwllqAWtqugKqfWeVfQsAj92zhkVg0p9O",
                "token_type": "Bearer",
                "expires_in": 3600
            }

+ Response 401 (application/json)
    + Body

            {
                "message": "Client authentication failed.",
                "status_code": 500
            }

## Get User by Access Token [POST /client/user]
Get user information by access token

+ Response 200 (application/json)
    + Body

            {
                "data": {
                    "id": 1,
                    "username": "administrator",
                    "email": "me@ngocnh.info",
                    "activation_key": null,
                    "last_visited": "2015-09-14 16:30:26",
                    "type": "default",
                    "status": 1,
                    "created_at": {
                        "date": "2015-09-14 15:49:49.000000",
                        "timezone_type": 3,
                        "timezone": "Asia/Ho_Chi_Minh"
                    },
                    "roles": [
                        {
                            "id": 1,
                            "name": "super-administrator",
                            "display_name": "Super Administrator",
                            "description": "Super Administrator",
                            "default": 0,
                            "permissions": [
                                {
                                    "access.all": "All Permissions"
                                }
                            ]
                        }
                    ],
                    "meta": {
                        "fullname": "Super Administrator"
                    }
                }
            }

+ Response 401 (application/json)
    + Body

            {
                "message": "Unauthorized.",
                "status_code": 401
            }

# Post [/post]
User resource representation.

## Show all pots [GET /post{?page,limit}]
Get a JSON representation of all the post.

+ Parameters
    + page (integer, optional) - The page of results to view.
        + Default: 1
    + limit (integer, optional) - The amount of results per page.
        + Default: 10

+ Response 200 (application/json)
    + Body

            {
                "data": [
                    {
                        "id": 1,
                        "title": "Post title",
                        "excerpt": "Post excerpt",
                        "slug": "post-title",
                        "content": "Post content",
                        "image": {
                            "name": "Screen Shot 2015-08-24 at 10_28_52 AM.png",
                            "url": "http://laravel5.app/storage/files/images/Screen Shot 2015-08-24 at 10_28_52 AM.png",
                            "size": 170017,
                            "title": null,
                            "description": null
                        },
                        "order": 1,
                        "type": "post",
                        "status": "publish",
                        "comment_status": "close",
                        "comment_count": 0,
                        "author": {
                            "id": 1,
                            "username": "administrator",
                            "email": "me@ngocnh.info",
                            "roles": {
                                "1": {
                                    "id": 1,
                                    "name": "super-administrator",
                                    "display_name": "Super Administrator",
                                    "description": "Super Administrator"
                                }
                            },
                            "activation_key": null,
                            "last_visited": "2015-09-03 15:40:29",
                            "type": "default",
                            "status": 1,
                            "created_at": {
                                "date": "2015-09-01 19:50:01.000000",
                                "timezone_type": 3,
                                "timezone": "Asia/Ho_Chi_Minh"
                            },
                            "meta": {
                                "fullname": "Super Administrator"
                            }
                        },
                        "taxonomies": [
                            {
                                "id": 1,
                                "name": "Default",
                                "slug": "default",
                                "description": "Default Post Taxonomy",
                                "parent": null,
                                "type": "post_category",
                                "order": 99,
                                "count": 2
                            }
                        ],
                        "tags": [
                            {
                                "id": 2,
                                "name": "Post",
                                "slug": "post",
                                "type": "post_tag",
                                "count": 1
                            },
                            {
                                "id": 3,
                                "name": "news",
                                "slug": "news",
                                "type": "post_tag",
                                "count": 1
                            },
                            {
                                "id": 4,
                                "name": "tag",
                                "slug": "tag",
                                "type": "post_tag",
                                "count": 1
                            }
                        ],
                        "translate": []
                    },
                    {
                        "id": 2,
                        "title": "Draft title",
                        "excerpt": "Draft excerpt",
                        "slug": "draft-title",
                        "content": "Draft content",
                        "image": {
                            "name": "Screen Shot 2015-08-21 at 3_14_57 PM.png",
                            "url": "http://laravel5.app/storage/files/images/Screen Shot 2015-08-21 at 3_14_57 PM.png",
                            "size": 16747,
                            "title": null,
                            "description": null
                        },
                        "order": 2,
                        "type": "post",
                        "status": "draft",
                        "comment_status": "close",
                        "comment_count": 0,
                        "author": {
                            "id": 1,
                            "username": "administrator",
                            "email": "me@ngocnh.info",
                            "roles": {
                                "1": {
                                    "id": 1,
                                    "name": "super-administrator",
                                    "display_name": "Super Administrator",
                                    "description": "Super Administrator"
                                }
                            },
                            "activation_key": null,
                            "last_visited": "2015-09-03 15:40:29",
                            "type": "default",
                            "status": 1,
                            "created_at": {
                                "date": "2015-09-01 19:50:01.000000",
                                "timezone_type": 3,
                                "timezone": "Asia/Ho_Chi_Minh"
                            },
                            "meta": {
                                "fullname": "Super Administrator"
                            }
                        },
                        "taxonomies": [
                            {
                                "id": 1,
                                "name": "Default",
                                "slug": "default",
                                "description": "Default Post Taxonomy",
                                "parent": null,
                                "type": "post_category",
                                "order": 99,
                                "count": 2
                            }
                        ],
                        "tags": [
                            {
                                "id": 5,
                                "name": "draft",
                                "slug": "draft",
                                "type": "post_tag",
                                "count": 1
                            },
                            {
                                "id": 6,
                                "name": "post",
                                "slug": "post-1",
                                "type": "post_tag",
                                "count": 1
                            }
                        ],
                        "translate": []
                    }
                ],
                "meta": {
                    "pagination": {
                        "total": 2,
                        "count": 2,
                        "per_page": 10,
                        "current_page": 1,
                        "total_pages": 1,
                        "links": []
                    }
                }
            }

## Get post. [GET /post/{id|slug}]
Get a post by post id or slug

+ Parameters
    + id (integer, required) - Post ID
    + slug (string, required) - Post Slug

+ Response 200 (application/json)
    + Body

            {
                "data": {
                    "id": 2,
                    "title": "Draft title",
                    "excerpt": "Draft excerpt",
                    "slug": "draft-title",
                    "content": "Draft content",
                    "image": {
                        "name": "Screen Shot 2015-08-21 at 3_14_57 PM.png",
                        "url": "http://laravel5.app/storage/files/images/Screen Shot 2015-08-21 at 3_14_57 PM.png",
                        "size": 16747,
                        "title": null,
                        "description": null
                    },
                    "order": 2,
                    "type": "post",
                    "status": "draft",
                    "comment_status": "close",
                    "comment_count": 0,
                    "author": {
                        "id": 1,
                        "username": "administrator",
                        "email": "me@ngocnh.info",
                        "roles": {
                            "1": {
                                "id": 1,
                                "name": "super-administrator",
                                "display_name": "Super Administrator",
                                "description": "Super Administrator"
                            }
                        },
                        "activation_key": null,
                        "last_visited": "2015-09-03 15:40:29",
                        "type": "default",
                        "status": 1,
                        "created_at": {
                            "date": "2015-09-01 19:50:01.000000",
                            "timezone_type": 3,
                            "timezone": "Asia/Ho_Chi_Minh"
                        },
                        "meta": {
                            "fullname": "Super Administrator"
                        }
                    },
                    "taxonomies": [
                        {
                            "id": 1,
                            "name": "Default",
                            "slug": "default",
                            "description": "Default Post Taxonomy",
                            "parent": null,
                            "type": "post_category",
                            "order": 99,
                            "count": 2
                        }
                    ],
                    "tags": [
                        {
                            "id": 5,
                            "name": "draft",
                            "slug": "draft",
                            "type": "post_tag",
                            "count": 1
                        },
                        {
                            "id": 6,
                            "name": "post",
                            "slug": "post-1",
                            "type": "post_tag",
                            "count": 1
                        }
                    ],
                    "translate": []
                }
            }

+ Response 404 (application/json)
    + Body

            {
                "message": "<strong>Error!</strong> Post <strong><i>{post}</i></strong> not found.",
                "status_code": 404
            }

# Category [/category]
User resource representation.

## Show all categories [GET /category{?page,limit}]
Get a JSON representation of all the category.

+ Parameters
    + page (integer, optional) - The page of results to view.
        + Default: 1
    + limit (integer, optional) - The amount of results per page.
        + Default: 10

+ Response 200 (application/json)
    + Body

            {
                "data": [
                    {
                        "id": 1,
                        "name": "Default",
                        "slug": "default",
                        "description": "Default Post Taxonomy",
                        "parent": null,
                        "order": 99,
                        "type": "post_category",
                        "count": 2,
                        "translate": []
                    }
                ],
                "meta": {
                    "pagination": {
                        "total": 1,
                        "count": 1,
                        "per_page": 10,
                        "current_page": 1,
                        "total_pages": 1,
                        "links": []
                    }
                }
            }

## Get Category. [GET /category/{id|slug}]
Get a category by category id or slug

+ Parameters
    + id (integer, required) - Category ID
    + slug (string, required) - Category Slug

+ Response 200 (application/json)
    + Body

            {
                "data": {
                    "id": 1,
                    "name": "Default",
                    "slug": "default",
                    "description": "Default Post Taxonomy",
                    "parent": null,
                    "order": 99,
                    "type": "post_category",
                    "count": 2,
                    "translate": []
                }
            }

+ Response 404 (application/json)
    + Body

            {
                "message": "<strong>Error!</strong> Category <strong><i>{category}</i></strong> not found.",
                "status_code": 404
            }

# Tag [/tag]
User resource representation.

## Show all tags [GET /tag{?page,limit}]
Get a JSON representation of all the tag.

+ Parameters
    + page (integer, optional) - The page of results to view.
        + Default: 1
    + limit (integer, optional) - The amount of results per page.
        + Default: 10

+ Response 200 (application/json)
    + Body

            {
                "data": [
                    {
                        "id": 2,
                        "name": "Post",
                        "slug": "post",
                        "description": null,
                        "parent": null,
                        "order": 1,
                        "type": "post_tag",
                        "count": 1,
                        "translate": []
                    },
                    {
                        "id": 3,
                        "name": "news",
                        "slug": "news",
                        "description": null,
                        "parent": null,
                        "order": 1,
                        "type": "post_tag",
                        "count": 1,
                        "translate": []
                    }
                ],
                "meta": {
                    "pagination": {
                        "total": 2,
                        "count": 2,
                        "per_page": 10,
                        "current_page": 1,
                        "total_pages": 1,
                        "links": []
                    }
                }
            }

## Get Tag. [GET /tag/{id|slug}]
Get a tag by tag id or slug

+ Parameters
    + id (integer, required) - Tag ID
    + slug (string, required) - Tag Slug

+ Response 200 (application/json)
    + Body

            {
                "data": {
                    "id": 2,
                    "name": "Post",
                    "slug": "post",
                    "description": null,
                    "parent": null,
                    "order": 1,
                    "type": "post_tag",
                    "count": 1,
                    "translate": []
                }
            }

+ Response 404 (application/json)
    + Body

            {
                "message": "<strong>Error!</strong> Tag <strong><i>{category}</i></strong> not found.",
                "status_code": 404
            }

# User [/user]
User resource representation.

## Login. [POST /user/user/login]
Login with account username or email and account password

+ Parameters
    + username (string, required) - Account username or email
    + password (string, required) - Account password

+ Request (application/json)
    + Body

            {
                "username": "user01@local.app",
                "password": "123456"
            }

+ Response 200 (application/json)
    + Body

            {
                "data": {
                    "id": 5,
                    "username": "user01",
                    "email": "user01@local.app",
                    "roles": {
                        "3": {
                            "id": 3,
                            "name": "test",
                            "display_name": "Test",
                            "description": "test"
                        }
                    },
                    "activation_key": "EKOmipkYuwE6o2tJsIxYJ3aP",
                    "last_visited": null,
                    "type": "default",
                    "status": 1,
                    "created_at": {
                        "date": "2015-09-02 00:49:02.000000",
                        "timezone_type": 3,
                        "timezone": "Asia/Ho_Chi_Minh"
                    },
                    "meta": []
                }
            }

+ Response 404 (application/json)
    + Body

            {
                "message": "<strong>Error!</strong> User <strong><i>user01@local.app</i></strong> not found.",
                "status_code": 422
            }

## Show all users [GET /user{?page,limit}]
Get a JSON representation of all the registered users.

+ Parameters
    + page (integer, optional) - The page of results to view.
        + Default: 1
    + limit (integer, optional) - The amount of results per page.
        + Default: 10

+ Response 200 (application/json)
    + Body

            {
                "data": [
                    {
                        "id": 1,
                        "username": "user01",
                        "email": "user01@local.app",
                        "roles": {
                            "1": {
                                "id": 1,
                                "name": "member",
                                "display_name": "Member",
                                "description": "Member"
                            }
                        },
                        "activation_key": null,
                        "last_visited": "2015-09-01 14:29:36",
                        "type": "default",
                        "status": 1,
                        "created_at": {
                            "date": "2015-08-29 01:58:30.000000",
                            "timezone_type": 3,
                            "timezone": "Asia/Ho_Chi_Minh"
                        },
                        "meta": {
                            "fullname": "User 01"
                        }
                    },
                    {
                        "id": 1,
                        "username": "user02",
                        "email": "user01@local.app",
                        "roles": {
                            "1": {
                                "id": 1,
                                "name": "Member",
                                "display_name": "Member",
                                "description": "Member"
                            }
                        },
                        "activation_key": null,
                        "last_visited": "2015-09-01 14:29:36",
                        "type": "default",
                        "status": 1,
                        "created_at": {
                            "date": "2015-08-29 01:58:30.000000",
                            "timezone_type": 3,
                            "timezone": "Asia/Ho_Chi_Minh"
                        },
                        "meta": {
                            "fullname": "User 02"
                        }
                    }
                ],
                "meta": {
                    "pagination": {
                        "total": 2,
                        "count": 2,
                        "per_page": 10,
                        "current_page": 1,
                        "total_pages": 1,
                        "links": ""
                    }
                }
            }

## Register user [POST /user]
Register a new user with a `username` and `password`.

+ Parameters
    + username (string, optional) - Account username
    + email (string, required) - Account email address
    + password (string, required) - Account password
    + password_confirm (string, required) - Password confirmed
    + meta (json, optional) - Account meta, any data by key:value , etc: 'first_name': 'A'

+ Request (application/json)
    + Body

            {
                "username": "user03",
                "email": "user03@local.app",
                "password": "secret",
                "password_confirm": "secret",
                "meta": {
                    "first_name": "User",
                    "last_name": "03"
                }
            }

+ Response 200 (application/json)
    + Body

            {
                "data": {
                    "id": 3,
                    "username": "user03",
                    "email": "user03@local.app",
                    "roles": {
                        "1": {
                            "id": 1,
                            "name": "member",
                            "display_name": "Member",
                            "description": "Member"
                        }
                    },
                    "activation_key": "EKOmipkYuwE6o2tJsIxYJ3aP",
                    "last_visited": "2015-09-01 14:29:36",
                    "type": "default",
                    "status": 1,
                    "created_at": {
                        "date": "2015-08-29 01:58:30.000000",
                        "timezone_type": 3,
                        "timezone": "Asia/Ho_Chi_Minh"
                    },
                    "meta": {
                        "first_name": "User",
                        "last_name": "03"
                    }
                }
            }

+ Response 422 (application/json)
    + Body

            {
                "message": "Resource validation failed!",
                "errors": {
                    "username": [
                        "The username has already been taken.",
                        "The username must be between 4 and 24 characters."
                    ],
                    "email": [
                        "The email field is required.",
                        "The email has already been taken.",
                        "The email may not be greater than 128 characters."
                    ],
                    "password": [
                        "The password field is required.",
                        "The password must be at least 6 characters."
                    ],
                    "password_confirm": [
                        "The password confirm field is required.",
                        "The password must be at least 6 characters."
                    ],
                    "meta": [
                        "The meta must be an json."
                    ]
                },
                "status_code": 422
            }

## Get user. [GET /user/{id}]
Get a user by user id

+ Parameters
    + id (integer, required) - User ID

+ Response 200 (application/json)
    + Body

            {
                "data": {
                    "id": 5,
                    "username": "user01",
                    "email": "user01@local.app",
                    "roles": {
                        "3": {
                            "id": 3,
                            "name": "test",
                            "display_name": "Test",
                            "description": "test"
                        }
                    },
                    "activation_key": "EKOmipkYuwE6o2tJsIxYJ3aP",
                    "last_visited": null,
                    "type": "default",
                    "status": 1,
                    "created_at": {
                        "date": "2015-09-02 00:49:02.000000",
                        "timezone_type": 3,
                        "timezone": "Asia/Ho_Chi_Minh"
                    },
                    "meta": []
                }
            }

+ Response 404 (application/json)
    + Body

            {
                "message": "<strong>Error!</strong> User <strong><i>6</i></strong> not found.",
                "status_code": 422
            }

## Update user [PUT /user/{id}]
Update a user by user id or change new password for user

+ Parameters
    + id (integer, required) - User id
    + username (string, optional) - New username
    + new_password (string, optional) - If user change password, set new_password for
     *                                 change
    + password_confirm (string, optional) - Password confirmed
    + meta (json, optional) - Account meta, any data by key:value , etc: 'first_name':
     *                         'A'

+ Request (application/json)
    + Body

            {
                "username": "user005",
                "new_password": "1234567",
                "password_confirm": "1234567"
            }

+ Response 200 (application/json)
    + Body

            {
                "data": {
                    "id": 5,
                    "username": "user005",
                    "email": "user01@local.app",
                    "roles": {
                        "3": {
                            "id": 3,
                            "name": "test",
                            "display_name": "Test",
                            "description": "test"
                        }
                    },
                    "activation_key": "EKOmipkYuwE6o2tJsIxYJ3aP",
                    "last_visited": null,
                    "type": "default",
                    "status": 0,
                    "created_at": {
                        "date": "2015-09-02 00:49:02.000000",
                        "timezone_type": 3,
                        "timezone": "Asia/Ho_Chi_Minh"
                    },
                    "meta": []
                }
            }

+ Response 403 (application/json)
    + Body

            {
                "message": "Access denied!",
                "status_code": 403
            }

+ Response 422 (application/json)
    + Body

            {
                "message": "Resource validation failed!",
                "errors": {
                    "username": [
                        "The username has already been taken.",
                        "The username must be between 4 and 24 characters."
                    ],
                    "new_password": [
                        "The new password must be at least 6 characters."
                    ],
                    "password_confirm": [
                        "The password confirm and new password must match.",
                        "The password confirm must be at least 6 characters."
                    ],
                    "meta": [
                        "The meta must be an json."
                    ]
                }
            }