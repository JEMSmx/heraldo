<?php 

    if(isset($input->post->sug)){
        $image_re=$input->post->idFoto;
        $page=wire('pages')->get($input->post->page);
        $page->setOutputFormatting(false);
        $page->images->trackChange('fav');
        $images=$page->images;
        $inc=0;
        foreach ($page->images as $image) {
            if($image==$image_re){
                if($image->fav==1){
                    $image->fav=0;
                }
                else{
                    $image->fav=1;
                }
                break;
            }
        }
        $page->metadata=1;
        $page->save();
        $page->setOutputFormatting(true);
    }else{
        $page=wire('pages')->get($input->post->page);
        $page->setOutputFormatting(false);
        $page->images->trackChange('fav');
        $images=$page->images;
        $inc=0;
        foreach ($page->images as $image) {
            $inc++;
            if($inc==$input->post->idFoto){
                if($image->fav==1){
                    $image->fav=0;
                }
                else{
                    $image->fav=1;
                }
                break;
            }
        }
        $page->metadata=1;
        $page->save();
        $page->setOutputFormatting(true);
    }
    

    echo "true";

