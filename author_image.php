<?php

class Author{

    private ?int $id = null;
    private string $image_size = 'medium';
    private bool $post;
    private int $image_id;

    public function __construct( int $id ){
        $this->id = $id;
        $this->post = Mock::get_post( $id );
        $this->image_id = Mock::get_post_image_id( $id );
    }

    public function set_image_size( string $value = '' ): Author{
        $this->image_size = $value; 
        return $this;
    }
    
    public function fetch_image_url( ): string{ 
        return Mock::get_post_thumbnail_url( $this->id, $this->image_size ); 
    }
}



class Mock{
    static public function get_post( int $id ): bool{
        return true;
    }
    static public function get_post_image_id( int $id ): int{
        return 21;
    }
    static public function get_post_thumbnail_url( int $id, string $size = '' ): string{
        switch( $size ){
            case 'medium':
                return 'https://service.mock/images/' . $id . '-600x600.jpg';
                break;
            case 'large':
                return 'https://service.mock/images/' . $id . '-1280x1280.jpg';
                break;
            default:
                return 'https://service.mock/images/' . $id . '.jpg';
                break;
        }
    }
}

$author = new Author( 37 );
$author_img_url = $author->set_image_size( 'large' )->fetch_image_url();
echo $author_img_url . PHP_EOL;
$author_img_url = $author->set_image_size( 'medium' )->fetch_image_url();
echo $author_img_url . PHP_EOL;
$author_img_url = $author->set_image_size( )->fetch_image_url();
echo $author_img_url . PHP_EOL;