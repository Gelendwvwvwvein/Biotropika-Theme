import { __ } from '@wordpress/i18n';
import {
  useBlockProps,
  InspectorControls,
  MediaUpload,
  MediaUploadCheck
} from '@wordpress/block-editor';
import { PanelBody, Button } from '@wordpress/components';

export default function Edit({ attributes, setAttributes }) {
  const { imageUrl, imageId } = attributes;
  const blockProps = useBlockProps();

  const onSelectMedia = (media) => {
    setAttributes({
      imageUrl: media.url,
      imageId:  media.id,
    });
  };

  return (
    <>
      <InspectorControls>
        <PanelBody title={__('Настройки картинки', 'biotropika')} initialOpen>
          <MediaUploadCheck>
            <MediaUpload
              onSelect={onSelectMedia}
              allowedTypes={['image']}
              value={imageId}
              render={({ open }) => (
                <Button onClick={open} isSecondary>
                  { !imageUrl
                    ? __('Выбрать изображение', 'biotropika')
                    : __('Изменить изображение', 'biotropika')
                  }
                </Button>
              )}
            />
            { imageUrl && (
              <Button
                onClick={() => setAttributes({ imageUrl: '', imageId: undefined })}
                isLink
                isDestructive
              >
                {__('Удалить картинку', 'biotropika')}
              </Button>
            ) }
          </MediaUploadCheck>
        </PanelBody>
      </InspectorControls>
      <div {...blockProps} className="biotropika-scroll-animation-block">
        { imageUrl
          ? <img
              src={imageUrl}
              alt=""
              className="scroll-animation-block__image"
            />
          : <div className="placeholder">
              {__('Картинка не выбрана', 'biotropika')}
            </div>
        }
      </div>
    </>
  );
}
