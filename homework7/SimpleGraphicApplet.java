import java.awt.Color;
import java.awt.Graphics;

import javax.swing.JApplet;
import javax.swing.JPanel;


@SuppressWarnings("serial")
public class SimpleGraphicApplet extends JApplet {
	
	public int additionalShapeType, additionalShapeColor;
	private JPanel panMain;
	
	public void drawShape(int type, int color) {
		additionalShapeColor = color;
		additionalShapeType = type;
		panMain.updateUI();
	}
	
	@Override
	public void init() {
		additionalShapeType = Integer.parseInt(this.getParameter("additionalShapeType"));
		additionalShapeColor = Integer.parseInt(this.getParameter("additionalShapeColor"));
		this.getContentPane().add(panMain = new JPanel() {
			@Override
			public void paint(Graphics g) {
				super.paint(g);
				g.setColor(Color.BLACK);
				g.drawRect(0, 0, 100, 100);
				g.setColor(Color.RED);
				g.fillRect(1, 1, 98, 98);
				g.setColor(Color.BLACK);
				g.drawOval(100, 0, 100, 100);
				g.setColor(Color.GREEN);
				g.fillOval(101, 1, 98, 98);
				if (additionalShapeType == 1) {
					g.setColor(Color.BLACK);
					g.drawRoundRect(50, 50, 100, 100, 5, 5);
					if (additionalShapeColor > 0) {
						if (additionalShapeColor == 1)
							g.setColor(Color.BLUE);
						else
							g.setColor(Color.ORANGE);
						g.fillRoundRect(50, 50, 100, 100, 5, 5);
					}
				} else if (additionalShapeType == 2) {
					g.setColor(Color.BLACK);
					g.drawOval(50, 50, 100, 50);
					if (additionalShapeColor > 0) {
						if (additionalShapeColor == 1)
							g.setColor(Color.BLUE);
						else
							g.setColor(Color.ORANGE);
						g.fillOval(50, 50, 100, 50);
					}
				}
			}
		});
	}
}
