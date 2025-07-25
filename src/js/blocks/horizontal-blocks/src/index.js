import { registerBlockType } from '@wordpress/blocks';
import Edit       from './editor';
import Heading    from '../../../../../templates/template-parts/components/Heading.js';
import Paragraph  from '../../../../../templates/template-parts/components/Paragraph.js';
import Button     from '../../../../../templates/template-parts/components/Button.js';
import Card       from '../../../../../templates/template-parts/components/Card.js';
import '../style/editor.scss';
import '../style/frontend.scss';

registerBlockType('biotropika/horizontal-blocks', {
  edit: Edit,
  save({ attributes }) {
    const { items } = attributes;

    return (
      <div className="biotropika-horizontal-blocks">
        {items.map((item, i) => (
          <Card className="horizontal-blocks__item" key={i}>
            {item.title && (
              <Heading level={3} className="horizontal-blocks__title">
                {item.title}
              </Heading>
            )}
            {item.text && (
              <Paragraph className="horizontal-blocks__text">
                {item.text}
              </Paragraph>
            )}
            {item.buttonText && item.buttonLink && (
              <Button
                className="horizontal-blocks__button"
                href={item.buttonLink}
              >
                {item.buttonText}
              </Button>
            )}
          </Card>
        ))}
      </div>
    );
  },
});
