import { registerBlockType } from '@wordpress/blocks';
import Edit from './editor';
import '../style/editor.scss';
import '../style/frontend.scss';

registerBlockType('biotropika/news-list-block', {
  edit: Edit,
  save() {
    // динамический блок — рендерим через PHP
    return null;
  },
});
