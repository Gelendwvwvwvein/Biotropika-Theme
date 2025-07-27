import { registerBlockType } from '@wordpress/blocks';
import Edit      from './editor';
import Heading   from '../../../../../templates/template-parts/components/Heading.js';
import Paragraph from '../../../../../templates/template-parts/components/Paragraph.js';
import Button    from '../../../../../templates/template-parts/components/Button.js';
import '../style/editor.scss';
import '../style/frontend.scss';

registerBlockType('biotropika/highlight-text-block', {
  edit: Edit,
  save({ attributes }) {
    const { title, content, buttonText, buttonLink } = attributes;
    return (
      <section className="biotropika-highlight-text-block">
        { title && (
          <Heading level={3} className="highlight-text__title">
            { title }
          </Heading>
        ) }
        { content && (
          <Paragraph className="highlight-text__content">
            { content }
          </Paragraph>
        ) }
        { buttonText && buttonLink && (
          <Button href={ buttonLink } className="highlight-text__button">
            { buttonText }
          </Button>
        ) }
      </section>
    );
  },
});
