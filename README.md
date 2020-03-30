# px2-report

[Pickles 2](https://pickles2.pxt.jp/) に、エラー検出を含むレポーティング機能を追加します。


## Usage - 使い方

### 1. Pickles 2 プロジェクト をセットアップ

[Pickles 2 のセットアップ手順](https://pickles2.pxt.jp/overview/setup/) を参照してください。

### 2. composer.json に追記

```
$ composer require tomk79/px2-report
```

### 3. config.php を更新

拡張子ごとのエラー検出をする場合は、 `processor` に設定します。

```php
$conf->funcs->processor->html = [

    /* 中略 */

    // px2-report
    // NGワード検出
    'tomk79\pickles2\px2report\found::ngwords('.json_encode([
        'nogood',
        'NoGood',
        'oo',
    ]).')' ,

    /* 中略 */

];
```

`before_output` にも設定できます。
この場合は、すべての拡張子のファイルがこの検査を通過することになります。

```php
$conf->funcs->before_output = [

    /* 中略 */

    // px2-report
    // NGワード検出
    'tomk79\pickles2\px2report\found::ngwords('.json_encode([
        'nogood',
        'NoGood',
        'oo',
    ]).')' ,

    /* 中略 */

];
```



## 更新履歴 - Change log

### tomk79/px2-report v0.1.0 (2020年3月31日)

- Initial Release


## for Developer

### Test

```bash
$ cd {$documentRoot}
$ ./vendor/phpunit/phpunit/phpunit
```
