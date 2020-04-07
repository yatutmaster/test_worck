<?


interface UserEntityInterface {

   /**
    * @param ArticleEntityInterface $article
    * 
    * @return void
    */
    function removeArticle(ArticleEntityInterface $article);
   /**
    * @param ArticleEntityInterface $article
    * 
    * @return void
    */
    function addArticle(ArticleEntityInterface $article);

}

interface ArticleEntityInterface {

   /**
    * @param UserEntityInterface $author
    * 
    * @return void
    */
    function setAuthor(UserEntityInterface $author);

}

/**
 * Class UserEntity
 */
class UserEntity implements UserEntityInterface {

    /**
     * @var undefined
     */
    private $_author;
    /**
     * @var array
     */
    private $_articles = [];


   /**
    * @param string $author
    * 
    * @return void
    */
    function __construct (string $author) {

        $this->_author = $author;

    }

   /**
    * @param ArticleEntity $article
    * 
    * @return void
    */
    function addArticle (ArticleEntityInterface $article){

        $article->setAuthor($this);

        $this->_articles[] = $article;


    }
   /**
    * @param ArticleEntity $article
    * 
    * @return void
    */
    function removeArticle (ArticleEntityInterface $article){

        foreach($this->_articles as $k => $item){

            if($item === $article){
                unset($this->_articles[$k]);
                break;

            }

        }

    }

   /**
    * @return void
    */
    function getAuthor (){

        return $this->_author;

    }

   /**
    * @return void
    */
    function getArticles (){

        return $this->_articles;

    }




}

/**
 * Class ArticleEntity
 */
class ArticleEntity implements ArticleEntityInterface {

    /**
     * @var undefined
     */
    private $_article;
    /**
     * @var undefined
     */
    private $_author;


   /**
    * @param string $article
    * 
    * @return void
    */
    function __construct (string $article) {

        $this->_article = $article;

    }

   /**
    * @param UserEntity $author
    * 
    * @return void
    */
    function setAuthor (UserEntityInterface $author) {

        $this->_author = $author;

    }

   /**
    * @return void
    */
    function getAuthorName () {

        return $this->_author->getAuthor();
        
    }

   /**
    * @param UserEntity $author
    * 
    * @return void
    */
    function changeAuthor (UserEntityInterface $author) {

        $this->_author->removeArticle($this);
        $author->addArticle($this);
    }


   /**
    * @return void
    */
    function getArticle () {

        return $this->_article;
    }




}

///TESTING

$user = new UserEntity('Vasya');
$user->addArticle ( new ArticleEntity('One article'));
$user->addArticle ( new ArticleEntity('Two article'));


$user2 = new UserEntity('Petya');
$user2->addArticle ( new ArticleEntity('One 2 article'));
$user2->addArticle ( new ArticleEntity('Two 2 article'));


// foreach ($user->getArticles() as $article){

//     echo $article->getAuthorName();

// }

$article = $user->getArticles()[0];

$article->changeAuthor($user2);


foreach ($user->getArticles() as $article){

    echo $article->getAuthorName().PHP_EOL;
    echo $article->getArticle().PHP_EOL;

}

echo '------'.PHP_EOL;

foreach ($user2->getArticles() as $article){

    echo $article->getAuthorName().PHP_EOL;
    echo $article->getArticle().PHP_EOL;

}



