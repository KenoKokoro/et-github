Feature: Login "POST" on "/v1/search/github/keyword"

    Scenario: Requires api key to be provided
        Given the "Content-Type" request header is "application/json"
        And the "Accept" request header is "application/json"
        When I request "/v1/search/github/keyword" using HTTP "get"
        Then the response code is 401
        And the response body contains JSON:
        """
        {
            "message": "Unauthorized.",
            "result": []
        }
        """

    Scenario: Requires keyword, owner and repository to be set
        Given the "Content-Type" request header is "application/json"
        And the "Accept" request header is "application/json"
        And the "Authorization" request header is "Bearer teststringapikey"
        When I request "/v1/search/github/keyword" using HTTP "get"
        Then the response code is 422
        And the response body contains JSON:
        """
        {
            "message": "Unprocessable Entity",
            "result": [],
            "validator": {
                "owner": ["The owner field is required."],
                "repository": ["The repository field is required."],
                "keyword": ["The keyword field is required."]
            }
        }
        """

    Scenario: Requires only one keyword to be set
        Given the "Content-Type" request header is "application/json"
        And the "Accept" request header is "application/json"
        And the "Authorization" request header is "Bearer teststringapikey"
        When I request "/v1/search/github/keyword?keyword=two%20words&owner=user&repository=repo" using HTTP "get"
        Then the response code is 422
        And the response body contains JSON:
        """
        {
            "message": "Unprocessable Entity",
            "result": [],
            "validator": {
                "keyword": ["Only one keyword is allowed."]
            }
        }
        """

    Scenario: Should return from the mocked repository and store to cache
        Given the "Content-Type" request header is "application/json"
        And the "Accept" request header is "application/json"
        And the "Authorization" request header is "Bearer teststringapikey"
        And the cache key for keyword query "word" owner "user" repository "repo" does not exists
        When I request "/v1/search/github/keyword?keyword=word&owner=user&repository=repo" using HTTP "get"
        Then the response code is 200
        And the response body contains JSON:
        """
        {
            "message": "Ok.",
            "result": ["file1", "file2"]
        }
        """
        And the cache key for keyword query "word" owner "user" repository "repo" exists
