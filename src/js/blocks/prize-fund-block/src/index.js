import { registerBlockType } from '@wordpress/blocks';
import Edit from './editor';
import '../style/editor.scss';
import '../style/frontend.scss';

registerBlockType('biotropika/prize-fund-block', {
  edit: Edit,
  save({ attributes }) {
    const { text } = attributes;
    return (
      <h2 className="biotropika-prize-fund-block">
        { text }
      </h2>
    );
  },
});
