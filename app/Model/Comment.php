<?php
class Comment extends AppModel {
    
    public $validate = array(
        'post_id' => array(
            'rule' => array('decimal'),
        ),
        'user_id' => array(
            'rule' => array('decimal'),
        ),
        'replyTo' => array(
            'rule' => array('decimal'),
            'required' => false
        ),
        'body' => array(
            'rule' => 'notEmpty'
        )
    );
    
    public $hasMany = array(
        'Replies' => array(
            'className' => 'Comment',
            'foreignKey' => 'id'
        )
    );
    
    public $belongsTo = array(
        'PostedBy' => array(
            'className' => 'User',
            'foreignKey' => 'user_id'
        ),
        'CommentedOn' => array(
            'className' => 'Post',
            'foreignKey' => 'post_id'
        ),
        'InReplyTo' => array(
            'className' => 'Comment',
            'foreignKey' => 'reply_to'
        ),  
    );
    
    public function getPostComments($postId) {
        $comments = $this->find('all', array(
            'recursive' => 0,
            'conditions' => array(
                'Comment.post_id' => $postId,
                'Comment.reply_to IS NULL'
            )
        ));
        foreach ($comments as &$comment) {
            $this->addCommentReplies($comment);
        }
        
        return $comments;
    }
    
    public function addCommentReplies(&$comment, $recursive = true) {
        $replies = $this->find('all', array(
            'conditions' => array(
                'Comment.reply_to' => $comment['Comment']['id']
            )
        ));
        if ($recursive) {
            foreach ($replies as &$reply) {
                $this->addCommentReplies($reply);
            }
        }
        $comment['Replies'] = $replies;
    }
    
}
