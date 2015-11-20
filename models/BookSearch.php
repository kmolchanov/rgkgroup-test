<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Book;

/**
 * BookSearch represents the model behind the search form about `app\models\Book`.
 */
class BookSearch extends Book
{
    public $author;
    public $released_from;
    public $released_to;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'released_at', 'author', 'author_id', 'created_at', 'updated_at'], 'integer'],
            [['title', 'image', 'released_from', 'released_to'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Book::find();
        $query->joinWith(['author']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $dataProvider->sort->attributes['author'] = [
            'asc' => ['{{%author}}.firstname, lastname' => SORT_ASC],
            'desc' => ['{{%author}}.firstname, lastname' => SORT_DESC],
        ];

        $query->andFilterWhere([
            'id' => $this->id,
            'released_at' => $this->released_at,
            '{{%author}}.id' => $this->author,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $from_date = !empty($this->released_from) ? strtotime($this->released_from) : $this->released_from;
        $to_date = !empty($this->released_to) ? strtotime($this->released_to) : $this->released_to;

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['>', 'released_at', $from_date])
            ->andFilterWhere(['<', 'released_at', $to_date]);

        return $dataProvider;
    }
}
